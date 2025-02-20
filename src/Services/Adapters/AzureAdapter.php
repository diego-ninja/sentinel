<?php

namespace Ninja\Sentinel\Services\Adapters;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

final readonly class AzureAdapter extends AbstractAdapter
{
    private const array SEVERITY_SCORES = [
        'Low' => 0.25,
        'Medium' => 0.5,
        'High' => 0.75,
        'Safe' => 0.0,
    ];

    /**
     * @param array{
     *     categoriesAnalysis: array<array{
     *         category: string,
     *         severity: string,
     *         confidence: float
     *     }>,
     *     blocklistsMatch?: array<array{
     *         text: string,
     *         offset?: int,
     *         length?: int
     *     }>
     * } $response
     */
    public function adapt(string $text, array $response): ServiceResponse
    {
        $matches = $this->createMatches($text, $response['blocklistsMatch'] ?? []);
        $categories = [];
        $maxScore = 0.0;
        $avgConfidence = 0.0;

        foreach ($response['categoriesAnalysis'] as $analysis) {
            if (($score = self::SEVERITY_SCORES[$analysis['severity']] ?? 0.0) >= 0.5) {
                $categories[] = Category::fromAzure($analysis['category']);
                $maxScore = max($maxScore, $score);
            }
            $avgConfidence += $analysis['confidence'];
        }

        $confidenceValue = count($response['categoriesAnalysis']) > 0
            ? $avgConfidence / count($response['categoriesAnalysis'])
            : 0.0;

        // Si hay matches, su score tiene prioridad
        $finalScore = $matches->isEmpty()
            ? new Score($maxScore)
            : $matches->score();

        return new readonly class ($text, $matches, $finalScore, new Confidence($confidenceValue), $categories) implements ServiceResponse {
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

    /**
     * @param array<array{
     *     text: string,
     *     offset?: int,
     *     length?: int
     * }> $blocklistMatches
     */
    private function createMatches(string $text, array $blocklistMatches): MatchCollection
    {
        $matches = new MatchCollection();

        foreach ($blocklistMatches as $match) {
            if ( ! isset($match['offset']) || ! isset($match['length'])) {
                $offset = mb_stripos($text, $match['text']);
                $length = mb_strlen($match['text']);
            } else {
                $offset = $match['offset'];
                $length = $match['length'];
            }

            if (false !== $offset) {
                $occurrences = new OccurrenceCollection([
                    new Position($offset, $length),
                ]);

                $matches->addCoincidence(
                    new Coincidence(
                        word: $match['text'],
                        type: MatchType::Exact,
                        score: Calculator::score($text, $match['text'], MatchType::Exact, $occurrences),
                        confidence: Calculator::confidence($text, $match['text'], MatchType::Exact, $occurrences),
                        occurrences: $occurrences,
                        context: ['source' => 'azure_blocklist'],
                    ),
                );
            }
        }

        return $matches;
    }
}
