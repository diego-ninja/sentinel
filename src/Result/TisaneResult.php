<?php

namespace Ninja\Censor\Result;

use Ninja\Censor\Enums\Category;
use Ninja\Censor\Result\Builder\ResultBuilder;
use Ninja\Censor\ValueObject\Score;
use Ninja\Censor\ValueObject\Sentiment;

final class TisaneResult extends AbstractResult
{
    /**
     * @param array{
     *   text: string,
     *   sentiment: float,
     *   topics?: array<string>,
     *   abuse?: array<array{
     *     type: string,
     *     severity: string,
     *     text: string,
     *     offset: int,
     *     length: int,
     *     sentence_index: int,
     *     explanation?: string,
     *   }>,
     *   sentiment_expressions?: array<array{
     *     sentence_index: int,
     *     offset: int,
     *     length: int,
     *     text: string,
     *     polarity: string,
     *     targets: array<string>,
     *     reasons?: array<string>,
     *     explanation?: string
     *   }>
     * } $response
     */
    public static function fromResponse(string $text, array $response): AbstractResult
    {
        $words = [];
        $categories = [];

        $abuses = $response['abuse'] ?? [];

        foreach ($abuses as $abuse) {
            $words[] = $abuse['text'];
            $categories[] = Category::fromTisane($abuse['type']);
        }

        /** @var string[] $words */
        $words = array_unique($words);

        $score = self::calculateScore($abuses);
        $sentiment = Sentiment::withScore(new Score((float) $response['sentiment']));

        $builder = new ResultBuilder;

        return $builder
            ->withOriginalText($text)
            ->withOffensive($score->value() >= config('censor.threshold_score') || count($words) > 0)
            ->withWords($words)
            ->withReplaced(self::clean($text, $words))
            ->withScore($score)
            ->withSentiment($sentiment)
            ->withCategories($categories)
            ->build();
    }

    /**
     * @param array<array{
     *   type: string,
     *   severity: string,
     *   text: string,
     *   offset: int,
     *   length: int,
     *   sentence_index: int,
     *   explanation?: string,
     * }> $abuses
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
