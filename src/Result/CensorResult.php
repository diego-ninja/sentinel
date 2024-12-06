<?php

namespace Ninja\Censor\Result;

final readonly class CensorResult extends AbstractResult
{
    /**
     * @param  array<int, array{word: string, type: string}>  $matchDetails
     */
    private function __construct(
        bool $offensive,
        array $words,
        string $replaced,
        string $original,
        ?float $score = null,
        ?float $confidence = null,
        ?array $categories = [],
        private array $matchDetails = []
    ) {
        parent::__construct($offensive, $words, $replaced, $original, $score, $confidence, $categories);
    }

    public static function fromResponse(string $text, array $response): self
    {
        /** @var array<int, array{word: string, type: string}> $matchDetails */
        $matchDetails = $response['details'] ?? [];

        // Filter out censored words from matchDetails
        $matchDetails = array_filter($matchDetails, function ($detail) {
            return ! str_contains($detail['word'], '*');
        });

        // Extract words from matchDetails
        $words = array_values(array_unique(array_column($matchDetails, 'word')));

        /** @var string $replaced */
        $replaced = $response['clean'] ?? $text;

        /** @var float|null $score */
        $score = $response['score'] ?? null;

        $confidence = self::calculateConfidence($matchDetails);

        // Text is considered offensive if:
        // 1. Contains any exact or ngram matches
        // 2. Has a high enough score (>= 0.5)
        // 3. Has multiple matches of any type
        $isOffensive = (
            count($words) > 0 && (
                count($words) > 1 ||
                ($score !== null && $score >= config('censor.threshold_score')) ||
                array_any($matchDetails, fn ($m) => in_array($m['type'], ['exact', 'ngram'], true))
            )
        );

        return new self(
            offensive: $isOffensive,
            words: $words,
            replaced: $replaced,
            original: $text,
            score: $score,
            confidence: $confidence,
            categories: null,
            matchDetails: $matchDetails
        );
    }

    /**
     * @return array<int, array{word: string, type: string}>
     */
    public function getMatchDetails(): array
    {
        return $this->matchDetails;
    }

    /**
     * @return array<int, string>
     */
    public function getMatchesByType(string $type): array
    {
        return array_values(array_map(
            fn ($detail) => $detail['word'],
            array_filter(
                $this->matchDetails,
                fn ($detail) => $detail['type'] === $type
            )
        ));
    }

    /**
     * @return array<int, string>
     */
    public function getMatchTypes(): array
    {
        return array_unique(array_column($this->matchDetails, 'type'));
    }

    /**
     * @param  array<int, array{word: string, type: string}>  $matchDetails
     */
    private static function calculateConfidence(array $matchDetails): float
    {
        if (count($matchDetails) === 0) {
            return 0.0;
        }

        $weights = [
            'exact' => 1.0,
            'ngram' => 0.9,
            'variation' => 0.8,
            'levenshtein' => 0.7,
            'unknown' => 0.5,
        ];

        $totalWeight = 0.0;
        $count = 0;

        foreach ($matchDetails as $detail) {
            $weight = $weights[$detail['type']] ?? $weights['unknown'];
            $totalWeight += $weight;
            $count++;
        }

        return $totalWeight / $count;
    }

    public function hasMatchType(string $type): bool
    {
        return in_array($type, $this->getMatchTypes(), true);
    }

    /**
     * @return array<string, int>
     */
    public function getMatchDistribution(): array
    {
        $distribution = [];
        foreach ($this->matchDetails as $detail) {
            $type = $detail['type'];
            $distribution[$type] = ($distribution[$type] ?? 0) + 1;
        }

        return $distribution;
    }
}
