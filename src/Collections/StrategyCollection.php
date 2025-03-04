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
        $this->orderByWeight();

        // Reset a voting system when strategies change
        $this->votingSystem = null;
    }

    /**
     * Detect offensive content using all strategies with weighted voting
     *
     * @param string $text Text to analyze
     * @param Language|null $language
     * @return MatchCollection Collection of matches with adjusted scores
     */
    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        // Use weighted voting if enabled
        if ($this->useWeightedVoting) {
            return $this->getVotingSystem()->detect($text, $language);
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
     * Order strategies by weight (highest first)
     *
     * @return void
     */
    private function orderByWeight(): void
    {
        $sorted = $this->sortByDesc(fn(DetectionStrategy $strategy) => $strategy->weight());
        $this->items = $sorted->values()->all();
    }
}
