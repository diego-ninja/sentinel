<?php

namespace Ninja\Sentinel\Collections;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Detection\Contracts\DetectionStrategy;
use Ninja\Sentinel\Detection\StrategyVotingSystem;
use Ninja\Sentinel\Language\Language;

/**
 * Collection of detection strategies that implements a weighted voting system
 *
 * @extends Collection<int, DetectionStrategy>
 */
final class StrategyCollection extends Collection implements DetectionStrategy
{
    /**
     * Flag to enable/disable weighted voting system
     *
     * @var bool
     */
    private bool $useWeightedVoting = true;

    /**
     * Flag to enable/disable early termination
     *
     * @var bool
     */
    private bool $useEarlyTermination = true;

    /**
     * Threshold for early termination
     *
     * @var float
     */
    private float $earlyTerminationThreshold = 0.8;

    /**
     * Max number of strategies to try before checking results
     *
     * @var int
     */
    private int $batchSize = 3;


    /**
     * @var StrategyVotingSystem|null
     */
    private ?StrategyVotingSystem $votingSystem = null;

    /**
     * Add a strategy to the collection if it doesn't already exist
     *
     * @param DetectionStrategy $strategy Strategy to add
     * @return void
     */
    public function addStrategy(DetectionStrategy $strategy): void
    {
        if ($this->contains($strategy)) {
            return;
        }

        $this->add($strategy);
        $this->orderByEfficiency();

        // Reset a voting system when strategies change
        $this->votingSystem = null;
    }

    /**
     * Detect offensive content using all strategies with weighted voting
     * and applying early termination when appropriate
     *
     * @param string $text Text to analyze
     * @param Language|null $language
     * @return MatchCollection Collection of matches with adjusted scores
     */
    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        // Use weighted voting if enabled
        if ($this->useWeightedVoting && ! $this->useEarlyTermination) {
            return $this->getVotingSystem()->detect($text, $language);
        }

        // Optimized strategy execution with early termination
        if ($this->useEarlyTermination) {
            return $this->detectWithEarlyTermination($text, $language);
        }

        // Legacy behavior (simple merging)
        $matches = new MatchCollection();

        foreach ($this->all() as $strategy) {
            /** @var DetectionStrategy $strategy */
            $matches = $matches->merge($strategy->detect($text, $language));
        }

        return $matches;
    }

    /**
     * Enable or disable the weighted voting system
     *
     * @param bool $enable Whether to enable voting
     * @return self
     */
    public function useWeightedVoting(bool $enable = true): self
    {
        $this->useWeightedVoting = $enable;
        return $this;
    }

    /**
     * Enable or disable early termination
     *
     * @param bool $enable Whether to enable early termination
     * @param float|null $threshold Optional threshold override
     * @return self
     */
    public function useEarlyTermination(bool $enable = true, ?float $threshold = null): self
    {
        $this->useEarlyTermination = $enable;

        if (null !== $threshold) {
            $this->earlyTerminationThreshold = max(0.5, min(0.95, $threshold));
        }

        return $this;
    }

    /**
     * Set batch size for strategy processing
     *
     * @param int $size Number of strategies to process before checking results
     * @return self
     */
    public function setBatchSize(int $size): self
    {
        $this->batchSize = max(1, min(10, $size));
        return $this;
    }

    /**
     * Get the overall efficiency for this collection of strategies
     *
     * @return float Weight value
     */

    public function efficiency(): float
    {
        if ($this->isEmpty()) {
            return 0.0;
        }

        /** @var float $totalEfficiency */
        $totalEfficiency = $this->sum(fn(DetectionStrategy $strategy) => $strategy->efficiency());
        $totalStrategies = $this->count();

        return $totalEfficiency / $totalStrategies;
    }

    /**
     * Get the overall weight for this collection of strategies
     *
     * @return float Weight value
     */
    public function weight(): float
    {
        if ($this->isEmpty()) {
            return 0.0;
        }

        /** @var float $totalWeight */
        $totalWeight = $this->sum(fn(DetectionStrategy $strategy) => $strategy->weight());
        $totalStrategies = $this->count();

        return $totalWeight / $totalStrategies;
    }

    /**
     * Detect with progressive strategy execution and early termination
     *
     * @param string $text Text to analyze
     * @param Language|null $language Language for analysis
     * @return MatchCollection Collection of matches
     */
    private function detectWithEarlyTermination(string $text, ?Language $language = null): MatchCollection
    {
        $matches = new MatchCollection();
        $strategiesCount = $this->count();
        $textLength = mb_strlen($text);

        // Adjust the early termination threshold based on text length
        $adjustedThreshold = $this->getAdjustedThreshold($textLength);

        // Execute strategies in batches, checking results between batches
        for ($i = 0; $i < $strategiesCount; $i += $this->batchSize) {
            $batchEndIndex = min($i + $this->batchSize, $strategiesCount);

            // Process current batch of strategies
            for ($j = $i; $j < $batchEndIndex; $j++) {
                /** @var DetectionStrategy $strategy */
                $strategy = $this->items[$j];
                $strategyMatches = $strategy->detect($text, $language);
                $matches = $matches->merge($strategyMatches);

                // Check if we can terminate after each high-confidence strategy
                if ($strategy->weight() > 0.85 && $this->shouldTerminateEarly($matches, $adjustedThreshold)) {
                    return $matches;
                }
            }

            // After processing each batch, check if we can terminate
            if ($this->shouldTerminateEarly($matches, $adjustedThreshold)) {
                return $matches;
            }

            // Adjust the threshold based on what we've found so far
            $adjustedThreshold = $this->updateThreshold($matches, $adjustedThreshold, $i, $strategiesCount);
        }

        return $matches;
    }

    /**
     * Determine if processing should terminate early based on current results
     *
     * @param MatchCollection $matches Current matches
     * @param float $threshold Confidence threshold for early termination
     * @return bool True if processing should terminate
     */
    private function shouldTerminateEarly(MatchCollection $matches, float $threshold): bool
    {
        // If no matches, continue processing
        if ($matches->isEmpty()) {
            return false;
        }

        // If high confidence and score found, terminate
        if ($matches->confidence()->value() > $threshold &&
            $matches->score()->value() > $threshold) {
            return true;
        }

        // If we have multiple matches with high confidence
        return $matches->count() >= 3 && $matches->confidence()->value() > 0.7;
    }

    /**
     * Get a threshold adjusted for text length
     *
     * @param int $textLength Length of the text being analyzed
     * @return float Adjusted threshold
     */
    private function getAdjustedThreshold(int $textLength): float
    {
        // For very short texts, use a higher threshold to avoid false positives
        if ($textLength < 10) {
            return min(0.95, $this->earlyTerminationThreshold + 0.15);
        }

        // For medium texts, use a standard threshold
        if ($textLength < 100) {
            return $this->earlyTerminationThreshold;
        }

        // For longer texts, reduce threshold slightly as more text means more chances
        // of finding offensive content
        return max(0.65, $this->earlyTerminationThreshold - 0.05);
    }

    /**
     * Update the threshold based on remaining strategies and current results
     *
     * @param MatchCollection $matches Current matches
     * @param float $currentThreshold Current threshold
     * @param int $processedCount Number of strategies processed
     * @param int $totalCount Total number of strategies
     * @return float Updated threshold
     */
    private function updateThreshold(
        MatchCollection $matches,
        float $currentThreshold,
        int $processedCount,
        int $totalCount,
    ): float {
        $remainingPortion = ($totalCount - $processedCount) / $totalCount;

        // If we've already processed many strategies without strong matches,
        // gradually lower the threshold to continue processing
        if ($matches->isEmpty() || $matches->confidence()->value() < 0.5) {
            return max(0.6, $currentThreshold - (0.1 * $remainingPortion));
        }

        // If we have promising results, keep threshold high
        if ($matches->confidence()->value() >= 0.7) {
            return min(0.9, $currentThreshold + 0.05);
        }

        return $currentThreshold;
    }

    /**
     * Get the voting system instance, creating it if needed
     *
     * @return StrategyVotingSystem
     */
    private function getVotingSystem(): StrategyVotingSystem
    {
        if (null === $this->votingSystem) {
            $this->votingSystem = new StrategyVotingSystem($this);
        }

        return $this->votingSystem;
    }

    /**
     * Order strategies by efficiency (weight/cost ratio)
     * Puts low-cost, high-weight strategies first
     *
     * @return void
     */
    private function orderByEfficiency(): void
    {
        $sorted = $this->sortBy(fn(DetectionStrategy $strategy) => $strategy->efficiency());
        $this->items = $sorted->values()->all();
    }

    private function orderByWeight(): void
    {
        $sorted = $this->sortByDesc(fn(DetectionStrategy $strategy) => $strategy->weight());
        $this->items = $sorted->values()->all();
    }
}
