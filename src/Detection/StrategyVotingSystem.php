<?php

namespace Ninja\Sentinel\Detection;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\StrategyCollection;
use Ninja\Sentinel\Detection\Contracts\DetectionStrategy;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;

/**
 * Implements a weighted voting system for detection strategies
 * where strategies with higher weights have more influence on the final result.
 */
final readonly class StrategyVotingSystem
{
    /**
     * Minimum confidence threshold for including a match in the final results
     */
    private const float MIN_CONFIDENCE_THRESHOLD = 0.35;

    /**
     * Maximum boost that can be applied to a match based on multiple strategy detections
     */
    private const float MAX_AGREEMENT_BOOST = 0.3;

    /**
     * Constructor
     *
     * @param StrategyCollection $strategies Collection of detection strategies
     */
    public function __construct(
        private StrategyCollection $strategies,
    ) {}

    /**
     * Detect offensive content using a weighted voting system across all strategies
     *
     * @param string $text Text to analyze
     * @param iterable<string> $words Dictionary of offensive words to detect
     * @return MatchCollection Collection of weighted, aggregated matches
     */
    public function detect(string $text, iterable $words): MatchCollection
    {
        // Run detection on all strategies and collect results
        $allResults = [];
        $strategyWeights = [];

        foreach ($this->strategies as $strategy) {
            /** @var DetectionStrategy $strategy */
            $strategyResult = $strategy->detect($text, $words);
            $weight = $strategy->weight();

            if ( ! $strategyResult->isEmpty()) {
                $allResults[] = [
                    'matches' => $strategyResult,
                    'weight' => $weight,
                ];
                $strategyWeights[] = $weight;
            }
        }

        // Return an empty collection if no matches found
        if (empty($allResults)) {
            return new MatchCollection();
        }

        // Calculate total weight for normalization
        $totalWeight = array_sum($strategyWeights);

        // Group matches by word for voting
        $matchesByWord = $this->groupMatchesByWord($allResults);

        // Create a final collection with weighted matches
        return $this->combineVotedMatches($matchesByWord, $totalWeight, $text);
    }

    /**
     * Group matches by the detected word to prepare for voting
     *
     * @param array<array{matches: MatchCollection, weight: float}> $results Results from all strategies
     * @return array<string, array<array{match: Coincidence, weight: float}>> Matches grouped by word
     */
    private function groupMatchesByWord(array $results): array
    {
        $matchesByWord = [];

        foreach ($results as $result) {
            $matches = $result['matches'];
            $weight = $result['weight'];

            foreach ($matches as $match) {
                /** @var Coincidence $match */
                $word = mb_strtolower($match->word());
                if ( ! isset($matchesByWord[$word])) {
                    $matchesByWord[$word] = [];
                }

                $matchesByWord[$word][] = [
                    'match' => $match,
                    'weight' => $weight,
                ];
            }
        }

        return $matchesByWord;
    }

    /**
     * Combine voted matches into a single collection with enhanced scores
     *
     * @param array<string, array<array{match: Coincidence, weight: float}>> $matchesByWord Matches grouped by word
     * @param float $totalWeight Total weight for normalization
     * @param string $text Original text for context
     * @return MatchCollection Final collection of weighted matches
     */
    private function combineVotedMatches(array $matchesByWord, float $totalWeight, string $text): MatchCollection
    {
        $finalCollection = new MatchCollection();

        foreach ($matchesByWord as $matches) {
            // Skip words with low confidence from all strategies
            if ($this->calculateAggregateConfidence($matches, $totalWeight) < self::MIN_CONFIDENCE_THRESHOLD) {
                continue;
            }

            // Find the match with highest original confidence
            $bestMatch = $this->getBestMatch($matches);
            $matchCount = count($matches);

            // Boost score based on agreement between strategies
            $agreementBoost = min(self::MAX_AGREEMENT_BOOST, 0.1 * ($matchCount - 1));
            $adjustedScore = min(1.0, $bestMatch->score()->value() * (1 + $agreementBoost));

            // Calculate weighted confidence
            $adjustedConfidence = $this->calculateAggregateConfidence($matches, $totalWeight);

            // Create enhanced match with adjusted scores
            $finalCollection->addCoincidence(new Coincidence(
                word: $bestMatch->word(),
                type: $bestMatch->type(),
                score: new Score($adjustedScore),
                confidence: new Confidence($adjustedConfidence),
                occurrences: $bestMatch->occurrences(),
                context: [
                    ...$bestMatch->context() ?? [],
                    'strategy_agreement' => $matchCount,
                    'strategy_count' => count($this->strategies),
                ],
            ));
        }

        return $finalCollection;
    }

    /**
     * Get the best match from a collection of matches for the same word
     *
     * @param array<array{match: Coincidence, weight: float}> $matches Matches for a word
     * @return Coincidence The best match based on type reliability and confidence
     */
    private function getBestMatch(array $matches): Coincidence
    {
        // First, prefer matches with more reliable match types
        $typeOrderedMatches = [];
        foreach ($matches as $matchData) {
            $match = $matchData['match'];
            $type = $match->type();

            // Prioritize exact and trie matches, then pattern matches
            if (MatchType::Exact === $type || MatchType::Trie === $type) {
                return $match;
            }

            $typeOrderedMatches[$type->value][] = $match;
        }

        // If we have pattern or ngram matches, prefer those
        foreach ([MatchType::Pattern, MatchType::NGram] as $preferredType) {
            if (isset($typeOrderedMatches[$preferredType->value])) {
                return $this->getHighestConfidenceMatch($typeOrderedMatches[$preferredType->value]);
            }
        }

        // Otherwise, just get the match with highest confidence
        return $this->getHighestConfidenceMatch(array_map(fn($m) => $m['match'], $matches));
    }

    /**
     * Get the match with highest confidence from a list of matches
     *
     * @param array<Coincidence> $matches List of matches
     * @return Coincidence Match with highest confidence
     */
    private function getHighestConfidenceMatch(array $matches): Coincidence
    {
        $highestConfidence = 0.0;
        $bestMatch = $matches[0];

        foreach ($matches as $match) {
            $confidence = $match->confidence()->value();
            if ($confidence > $highestConfidence) {
                $highestConfidence = $confidence;
                $bestMatch = $match;
            }
        }

        return $bestMatch;
    }

    /**
     * Calculate aggregate confidence across multiple strategies
     *
     * @param array<array{match: Coincidence, weight: float}> $matches Matches for a word
     * @param float $totalWeight Total weight for normalization
     * @return float Weighted average confidence
     */
    private function calculateAggregateConfidence(array $matches, float $totalWeight): float
    {
        $weightedConfidenceSum = 0.0;
        $weightSum = 0.0;

        foreach ($matches as $matchData) {
            $match = $matchData['match'];
            $weight = $matchData['weight'];

            $weightedConfidenceSum += $match->confidence()->value() * $weight;
            $weightSum += $weight;
        }

        return $weightSum > 0 ? $weightedConfidenceSum / $weightSum : 0.0;
    }
}
