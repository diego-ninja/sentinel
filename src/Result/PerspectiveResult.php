<?php

namespace Ninja\Censor\Result;

final readonly class PerspectiveResult extends AbstractResult
{
    public static function fromResponse(string $text, array $response): AbstractResult
    {
        /**
         * @var array{
         *     attributeScores: array{
         *         TOXICITY: array{
         *             summaryScore: array{
         *                 value: float|null,
         *                 confidence: float|null
         *             }
         *         }
         *     }
         * } $response
         */
        $score = $response['attributeScores']['TOXICITY']['summaryScore']['value'] ?? null;

        /** @var float $confidence */
        $confidence = $response['attributeScores']['TOXICITY']['summaryScore']['confidence'] ?? null;

        $categories = [];

        $scores = $response['attributeScores'] ?? [];
        foreach ($scores as $category => $data) {
            if (($data['summaryScore']['value'] ?? 0) > 0.5) {
                $categories[] = strtolower($category);
            }
        }

        return new self(
            offensive: ($score ?? 0) > 0.7,
            words: [],
            replaced: $text,
            original: $text,
            score: $score,
            confidence: $confidence,
            categories: $categories
        );
    }
}
