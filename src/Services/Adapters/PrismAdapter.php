<?php

namespace Ninja\Censor\Services\Adapters;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Collections\OccurrenceCollection;
use Ninja\Censor\Enums\Category;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Enums\SentimentType;
use Ninja\Censor\Services\Contracts\ServiceAdapter;
use Ninja\Censor\Services\Contracts\ServiceResponse;
use Ninja\Censor\ValueObject\Coincidence;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Position;
use Ninja\Censor\ValueObject\Score;
use Ninja\Censor\ValueObject\Sentiment;

/**
 * Adapter for Prism LLM responses
 */
final readonly class PrismAdapter extends AbstractAdapter implements ServiceAdapter
{
    /**
     * @param string $text Original text
     * @param array{
     *     is_offensive: bool,
     *     offensive_words: array<string>,
     *     categories: array<string>,
     *     confidence: float,
     *     severity: float,
     *     sentiment: array{type: string, score: float},
     *     matches: array<int, array{
     *         text: string,
     *         match_type: string,
     *         score: float,
     *         confidence: float,
     *         occurrences: array<int, array{start: int, length: int}>,
     *         context?: array{original?: string, surrounding?: string}
     *     }>
     * } $response
     */
    public function adapt(string $text, array $response): ServiceResponse
    {
        $matches = $this->createMatches($response['matches']);

        return new readonly class ($text, $response, $matches) implements ServiceResponse {
            /**
             * @param string $text
             * @param  array{
             *     is_offensive: bool,
             *     offensive_words: array<string>,
             *     categories: array<string>,
             *     confidence: float,
             *     severity: float,
             *     sentiment: array{type: string, score: float},
             *     matches: array
             * } $response
             * @param MatchCollection|null $matches
             */
            public function __construct(
                private string $text,
                private array $response,
                private ?MatchCollection $matches,
            ) {}

            public function original(): string
            {
                return $this->text;
            }

            public function replaced(): string
            {
                if ( ! $this->matches) {
                    return $this->text;
                }
                return $this->matches->clean($this->text);
            }

            public function matches(): ?MatchCollection
            {
                return $this->matches;
            }

            public function score(): Score
            {
                return new Score($this->response['severity']);
            }

            public function confidence(): Confidence
            {
                return new Confidence($this->response['confidence']);
            }

            /** @return array<Category> */
            public function categories(): array
            {
                return array_map(
                    function (string $category) {
                        return match (mb_strtolower($category)) {
                            'hate_speech', 'hate' => Category::HateSpeech,
                            'harassment' => Category::Harassment,
                            'sexual', 'adult' => Category::Sexual,
                            'violence' => Category::Violence,
                            'threat' => Category::Threat,
                            'toxicity' => Category::Toxicity,
                            default => Category::Profanity,
                        };
                    },
                    $this->response['categories'],
                );
            }

            public function sentiment(): Sentiment
            {
                $sentiment = $this->response['sentiment'];
                return new Sentiment(
                    type: match (mb_strtolower($sentiment['type'])) {
                        'positive' => SentimentType::Positive,
                        'negative' => SentimentType::Negative,
                        'neutral' => SentimentType::Neutral,
                        'mixed' => SentimentType::Mixed,
                        default => SentimentType::Unknown,
                    },
                    score: new Score($sentiment['score']),
                );
            }
        };
    }

    /**
     * @param array<int, array{
     *     text: string,
     *     match_type: string,
     *     score: float,
     *     confidence: float,
     *     occurrences: array<int, array{start: int, length: int}>,
     *     context?: array{original?: string, surrounding?: string}
     * }> $matches
     */
    private function createMatches(array $matches): MatchCollection
    {
        $collection = new MatchCollection();

        foreach ($matches as $match) {
            $occurrences = new OccurrenceCollection();

            foreach ($match['occurrences'] as $occurrence) {
                $occurrences->addPosition(new Position(
                    start: $occurrence['start'],
                    length: $occurrence['length'],
                ));
            }

            $collection->addCoincidence(new Coincidence(
                word: $match['text'],
                type: $this->mapMatchType($match['match_type']),
                score: new Score($match['score']),
                confidence: new Confidence($match['confidence']),
                occurrences: $occurrences,
                context: $match['context'] ?? null,
            ));
        }

        return $collection;
    }

    private function mapMatchType(string $type): MatchType
    {
        return match (mb_strtolower($type)) {
            'pattern' => MatchType::Pattern,
            'variation' => MatchType::Variation,
            'ngram' => MatchType::NGram,
            'repeated' => MatchType::Repeated,
            default => MatchType::Exact,
        };
    }
}
