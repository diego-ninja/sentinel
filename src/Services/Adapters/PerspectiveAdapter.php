<?php

namespace Ninja\Sentinel\Services\Adapters;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

final readonly class PerspectiveAdapter extends AbstractAdapter
{
    private const array RELEVANT_ATTRIBUTES = [
        'TOXICITY' => 0.8,
        'SEVERE_TOXICITY' => 1.0,
        'THREAT' => 0.9,
        'PROFANITY' => 0.7,
    ];

    /**
     * @param array{
     *     attributeScores: array<string, array{
     *         spanScores?: array<array{
     *             begin: int,
     *             end: int,
     *             score: array{value: float}
     *         }>,
     *         summaryScore: array{
     *             value: float,
     *             confidence: float
     *         }
     *     }>
     * } $response
     */
    public function adapt(string $text, array $response): ServiceResponse
    {
        $matches = new MatchCollection();
        $maxScore = 0.0;
        $avgConfidence = 0.0;
        $categories = [];

        $language = app(LanguageCollection::class)->bestFor($text);

        foreach ($response['attributeScores'] as $attribute => $data) {
            $weight = self::RELEVANT_ATTRIBUTES[$attribute] ?? 0.0;
            $score = $data['summaryScore']['value'] * $weight;

            if ($score > 0.5) {
                $categories[] = Category::fromPerspective($attribute);
            }

            $maxScore = max($maxScore, $score);
            $avgConfidence += $data['summaryScore']['confidence'] ?? 0.0;

            if (isset($data['spanScores'])) {
                foreach ($data['spanScores'] as $span) {
                    $length = $span['end'] - $span['begin'];
                    $word = mb_substr($text, $span['begin'], $length);

                    $occurrences = new OccurrenceCollection([
                        new Position($span['begin'], $length),
                    ]);

                    $matches->addCoincidence(
                        new Coincidence(
                            word: $word,
                            type: MatchType::Exact,
                            score: new Score($span['score']['value']),
                            confidence: new Confidence(($data['summaryScore']['confidence'] ?? 0.7)),
                            occurrences: $occurrences,
                            language: $language->code(),
                            context: [
                                'attribute' => $attribute,
                                'score' => $span['score']['value'],
                            ],
                        ),
                    );
                }
            }
        }

        $confidenceValue = ! empty($response['attributeScores'])
            ? $avgConfidence / count($response['attributeScores'])
            : 0.0;

        return new readonly class ($text, $matches, new Score($maxScore), new Confidence($confidenceValue), $categories) implements ServiceResponse {
            public function __construct(
                private string          $original,
                private MatchCollection $matches,
                private Score           $score,
                private Confidence      $confidence,
                /** @var array<Category> */
                private array           $categories,
            ) {}

            public function original(): string
            {
                return $this->original;
            }

            public function replaced(): string
            {
                return $this->matches->clean($this->original);
            }

            public function matches(): MatchCollection
            {
                return $this->matches;
            }

            public function score(): Score
            {
                return $this->score;
            }

            public function confidence(): Confidence
            {
                return $this->confidence;
            }

            /** @return array<Category> */
            public function categories(): array
            {
                return $this->categories;
            }

            public function sentiment(): ?Sentiment
            {
                return null;
            }
        };
    }
}
