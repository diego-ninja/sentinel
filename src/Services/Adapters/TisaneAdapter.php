<?php

namespace Ninja\Sentinel\Services\Adapters;

use InvalidArgumentException;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

/**
 * @immutable
 */
final readonly class TisaneAdapter extends AbstractAdapter
{
    /**
     * @param array{
     *   text: string,
     *   sentiment: float,
     *   abuse?: array<array{
     *     type: string,
     *     severity: string,
     *     text: string,
     *     offset: int,
     *     length: int
     *   }>,
     * } $response
     */
    public function adapt(string $text, array $response): ServiceResponse
    {
        $matches = new MatchCollection();
        $categories = [];

        $language = app(LanguageCollection::class)->bestFor($text);

        foreach ($response['abuse'] ?? [] as $abuse) {
            $occurrences = new OccurrenceCollection([
                new Position($abuse['offset'], $abuse['length']),
            ]);

            try {
                $category = Category::fromTisane($abuse['type']);
                if ( ! in_array($category, $categories)) {
                    $categories[] = $category;
                }
            } catch (InvalidArgumentException) {
                continue;
            }

            $matches->addCoincidence(
                new Coincidence(
                    word: $abuse['text'],
                    type: MatchType::Exact,
                    score: Calculator::score($text, $abuse['text'], MatchType::Exact, $occurrences, $language),
                    confidence: Calculator::confidence($text, $abuse['text'], MatchType::Exact, $occurrences),
                    occurrences: $occurrences,
                    language: $language?->code() ?? LanguageCode::English,
                    context: [
                        'type' => $abuse['type'],
                        'severity' => $abuse['severity'],
                    ],
                ),
            );

        }

        $sentiment = $this->createSentiment($response['sentiment']);
        $score = $this->calculateScore($matches, $sentiment);

        return new readonly class ($text, $matches, $score, $sentiment, $categories, $language?->code() ?? LanguageCode::English) implements ServiceResponse {
            /**
             * @param  array<Category>  $categories
             */
            public function __construct(
                private string          $original,
                private MatchCollection $matches,
                private Score           $score,
                private Sentiment       $sentiment,
                private array           $categories,
                private LanguageCode    $language,
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
                return $this->matches->confidence();
            }

            /** @return array<Category> */
            public function categories(): array
            {
                return $this->categories;
            }

            public function sentiment(): Sentiment
            {
                return $this->sentiment;
            }

            public function language(): LanguageCode
            {
                return $this->language;
            }
        };
    }

    private function calculateScore(MatchCollection $matches, Sentiment $sentiment): Score
    {
        if ( ! $matches->isEmpty()) {
            $matchScore = $matches->score()->value();

            $sentimentModifier = match (true) {
                $sentiment->value() < 0 => abs($sentiment->value()) * 0.2,
                $sentiment->value() > 0 => -($sentiment->value() * 0.1),
                default => 0,
            };

            return new Score(min(1.0, $matchScore + $sentimentModifier));
        }

        if ($sentiment->value() < -0.7) {
            return new Score(abs($sentiment->value()) * 0.5);
        }

        return new Score(0.0);
    }

}
