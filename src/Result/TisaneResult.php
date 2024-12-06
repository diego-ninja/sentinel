<?php

namespace Ninja\Censor\Result;

final readonly class TisaneResult extends AbstractResult
{
    public static function fromResponse(string $text, array $response): AbstractResult
    {
        $words = [];
        $categories = [];

        /** @var array<int, array<string, mixed>> $abuses */
        $abuses = $response['abuse'] ?? [];

        foreach ($abuses as $abuse) {
            $words[] = $abuse['text'];
            $categories[] = $abuse['type'];
        }

        /** @var array<int, array<string, mixed>> $profanities */
        $profanities = $response['profanity'] ?? [];
        foreach ($profanities as $profanity) {
            $words[] = $profanity['text'];
            $categories[] = 'profanity';
        }

        /** @var string[] $words */
        $words = array_unique($words);

        /** @var string[] $categories */
        $categories = array_unique($categories);

        $score = self::calculateScore($abuses);

        return new self(
            offensive: $score >= config('censor.threshold_score') || count($words) > 0,
            words: $words,
            replaced: self::clean($text, $words),
            original: $text,
            score: $score,
            confidence: null,
            categories: $categories
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $abuses
     */
    private static function calculateScore(array $abuses): float
    {
        if (count($abuses) === 0) {
            return 0.0;
        }

        $scores = array_map(function ($severity) {
            return match ($severity) {
                'low' => 0.10,
                'medium' => 0.50,
                'high' => 0.75,
                'extreme' => 0.99,
                default => 0.0
            };
        }, array_column($abuses, 'severity'));

        return array_sum($scores) / count($scores);
    }
}
