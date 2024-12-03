<?php

namespace Ninja\Censor\Result;

final readonly class AzureResult extends AbstractResult
{
    private const SEVERITY_THRESHOLDS = [
        'Safe' => 0,
        'Low' => 2,
        'Medium' => 4,
        'High' => 6,
    ];

    private const CATEGORY_MAPPING = [
        'Hate' => 'hate_speech',
        'SelfHarm' => 'self_harm',
        'Sexual' => 'sexual_content',
        'Violence' => 'violence',
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

        foreach ($response['categoriesAnalysis'] ?? [] as $category) {
            $severity = self::SEVERITY_THRESHOLDS[$category['severity']] ?? 0;

            if ($severity >= 4) { // Medium o High
                $categories[] = self::CATEGORY_MAPPING[$category['category']] ?? $category['category'];
            }

            $maxSeverity = max($maxSeverity, $severity);
        }

        $words = array_map(
            fn ($term) => $term['text'],
            $response['blocklistsMatch'] ?? []
        );

        $score = $maxSeverity / 6;

        $confidences = array_column($response['categoriesAnalysis'] ?? [], 'confidence');
        $confidence = count($confidences) > 0 ? array_sum($confidences) / count($confidences) : null;

        return new self(
            offensive: $score >= 0.6 || count($words) > 0,
            words: $words,
            replaced: self::clean($text, $words),
            original: $text,
            score: $score,
            confidence: $confidence,
            categories: $categories
        );
    }
}
