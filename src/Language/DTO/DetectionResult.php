<?php

namespace Ninja\Sentinel\Language\DTO;

use JsonSerializable;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;

/**
 * @phpstan-type LanguageDetectionDetails array{
 *     pronouns: string[],
 *     markers: string[],
 *     intensifiers: string[],
 *     modifiers: string[],
 *     quotes: string[],
 *     excuses: string[],
 *     common_words: string[],
 *     word_count: int,
 *     unique_word_count: int,
 *     total_language_elements: int,
 *     percentage_of_language_elements: float,
 *     raw_score: int
 * }
 */
final readonly class DetectionResult implements JsonSerializable
{
    /**
     * @param LanguageCode $code
     * @param Score $score
     * @param Confidence $confidence
     * @param LanguageDetectionDetails|array{} $details
     */
    public function __construct(public LanguageCode $code, public Score $score, public Confidence $confidence, public array $details) {}

    /**
     * @param string|array{
     *     code: string,
     *     score: float,
     *     confidence: float,
     *     details: LanguageDetectionDetails
     * }|self $data
     * @return self
     */
    public static function from(string|array|self $data): self
    {
        if ($data instanceof self) {
            return $data;
        }

        if (is_string($data)) {
            $data = json_decode($data, true);

            /** @var array{code: string, score: float, confidence: float, details: LanguageDetectionDetails} $data */
            return self::from($data);
        }

        return new self(
            LanguageCode::from($data['code']),
            new Score($data['score']),
            new Confidence($data['confidence']),
            $data['details'] ?? [],
        );
    }

    public static function empty(): self
    {
        return new self(
            LanguageCode::Unknown,
            new Score(0.0),
            new Confidence(0.0),
            [
                'pronouns' => [],
                'markers' => [],
                'intensifiers' => [],
                'modifiers' => [],
                'quotes' => [],
                'excuses' => [],
                'common_words' => [],
                'word_count' => 0,
                'unique_word_count' => 0,
                'total_language_elements' => 0,
                'percentage_of_language_elements' => 0.0,
                'raw_score' => 0,
            ],
        );
    }

    /**
     * @return array{
     *     score: float,
     *     confidence: float,
     *     details: LanguageDetectionDetails|array{}
     * }
     */
    public function array(): array
    {
        return [
            'code' => $this->code->value,
            'score' => $this->score->value(),
            'confidence' => $this->confidence->value(),
            'details' => $this->details,
        ];
    }

    /**
     * @return array{
     *     score: float,
     *     confidence: float,
     *     details: LanguageDetectionDetails|array{}
     * }
     */
    public function jsonSerialize(): array
    {
        return $this->array();
    }
}
