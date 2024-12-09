<?php

namespace Ninja\Censor\Result;

use Ninja\Censor\Result\Builder\ResultBuilder;
use Ninja\Censor\ValueObject\Score;

final class TisaneResult extends AbstractResult
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

        $builder = new ResultBuilder;
        return $builder
            ->withOriginalText($text)
            ->withOffensive($score->value() >= config('censor.threshold_score') || count($words) > 0)
            ->withWords($words)
            ->withReplaced(self::clean($text, $words))
            ->withScore($score)
            ->withCategories($categories)
            ->build();
    }

    /**
     * @param  array<int, array<string, mixed>>  $abuses
     */
    private static function calculateScore(array $abuses): Score
    {
        if (count($abuses) === 0) {
            return new Score(0.0);
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

        return new Score(array_sum($scores) / count($scores));
    }
}
