<?php

namespace Ninja\Sentinel\Services\Adapters;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Enums\SentimentType;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

/**
 * Adapter for Prism LLM responses
 */
final readonly class PrismAdapter extends AbstractAdapter implements ServiceAdapter
{
    /**
     * @param string $text
     * @param array{
     *     detected_language: string,
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
     * @return ServiceResponse
     */
    public function adapt(string $text, array $response): ServiceResponse
    {
        $matches = $this->createMatches($response['matches'], LanguageCode::from($response['detected_language']));

        return new readonly class ($text, $response, $matches) implements ServiceResponse {
            /**
             * @param array{
             *     detected_language: string,
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
    private function createMatches(array $matches, LanguageCode $language): MatchCollection
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
                language: $language,
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
