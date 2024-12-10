<?php

namespace Ninja\Censor\Result;

use Ninja\Censor\Enums\Category;
use Ninja\Censor\Result\Builder\ResultBuilder;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

final class AzureResult extends AbstractResult
{
    private const SEVERITY_THRESHOLDS = [
        'Safe' => 0,
        'Low' => 2,
        'Medium' => 4,
        'High' => 6,
    ];

    public static function fromResponse(string $text, array $response): AbstractResult
    {
        /**
         * @var array{
         *     categoriesAnalysis: array<int, array{
         *         category: string,
         *         severity: string,
         *         confidence: float
         *     }>,
         *     blocklistsMatch: array<int, array{
         *         text: string
         *     }>
         * } $response
         */
        $categories = [];
        $maxSeverity = 0;

        $builder = new ResultBuilder;

        foreach ($response['categoriesAnalysis'] ?? [] as $category) {
            $severity = self::SEVERITY_THRESHOLDS[$category['severity']] ?? 0;

            if ($severity >= 4) { // Medium o High
                $categories[] = Category::fromAzure($category['category']);
            }

            $maxSeverity = max($maxSeverity, $severity);
        }

        $words = array_map(
            fn ($term) => $term['text'],
            $response['blocklistsMatch'] ?? []
        );

        $score = new Score($maxSeverity / 6);

        $confidences = array_column($response['categoriesAnalysis'] ?? [], 'confidence');
        $confidence = count($confidences) > 0 ? new Confidence(array_sum($confidences) / count($confidences)) : null;

        return $builder
            ->withOriginalText($text)
            ->withReplaced(self::clean($text, $words))
            ->withScore($score)
            ->withConfidence($confidence)
            ->withCategories($categories)
            ->withOffensive($score->value() >= config('censor.threshold_score') || count($words) > 0)
            ->withWords($words)
            ->build();
    }
}
