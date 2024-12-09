<?php

namespace Ninja\Censor\Result;

use Ninja\Censor\Result\Builder\ResultBuilder;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

final class PerspectiveResult extends AbstractResult
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

        $builder = new ResultBuilder;
        return $builder
            ->withOriginalText($text)
            ->withOffensive(($score ?? 0) > config('censor.threshold_score'))
            ->withWords([])
            ->withReplaced($text)
            ->withScore(new Score($score ?? 0))
            ->withConfidence(new Confidence($confidence ?? 0))
            ->withCategories($categories)
            ->build();

    }
}
