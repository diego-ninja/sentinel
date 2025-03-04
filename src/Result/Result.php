<?php

namespace Ninja\Sentinel\Result;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Result\Contracts\Result as ResultContract;
use Ninja\Sentinel\Support\ThresholdManager;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

readonly class Result implements ResultContract
{
    /**
     * @param  array<string>  $words List of detected offensive words
     * @param  array<Category>|null  $categories Detected content categories
     */
    public function __construct(
        public bool             $offensive,
        public array            $words,
        public string           $replaced,
        public string           $original,
        public ?MatchCollection $matches,
        public ?Score           $score = null,
        public ?Confidence      $confidence = null,
        public ?Sentiment       $sentiment = null,
        public ?array           $categories = null,
        public ?ContentType     $contentType = null,
        public ?Audience        $audience = null,
    ) {}

    /**
     * Determine if content is offensive, optionally with language parameters
     *
     * @param ContentType|null $contentType Type of content being analyzed (overrides constructor value)
     * @param Audience|null $audienceType Target audience for content (overrides constructor value)
     * @return bool True if the content is considered offensive
     */
    public function offensive(?ContentType $contentType = null, ?Audience $audienceType = null): bool
    {
        // If we have matches, use their threshold-aware implementation
        if (null !== $this->matches) {
            return $this->matches->offensive(
                $this->original,
                $this->categories,
                $contentType ?? $this->contentType,
                $audienceType ?? $this->audience,
            );
        }

        // If we already have a pre-calculated value and no language overrides
        if (null === $contentType && null === $audienceType) {
            return $this->offensive;
        }

        // Calculate using threshold manager
        $threshold = ThresholdManager::getThreshold(
            $this->categories ?? [],
            $contentType ?? $this->contentType,
            $audienceType ?? $this->audience,
        );

        return null !== $this->score && $this->score->value() >= $threshold;
    }

    /**
     * Get list of detected offensive words
     *
     * @return array<string> List of offensive words
     */
    public function words(): array
    {
        return $this->words;
    }

    /**
     * Get the text with offensive content masked
     *
     * @return string Cleaned text
     */
    public function replaced(): string
    {
        return $this->replaced;
    }

    /**
     * Get the original text
     *
     * @return string Original text
     */
    public function original(): string
    {
        return $this->original;
    }

    /**
     * Get the content score
     *
     * @return Score|null Content score or null if not available
     */
    public function score(): ?Score
    {
        return $this->score;
    }

    /**
     * Get the confidence level
     *
     * @return Confidence|null Confidence level or null if not available
     */
    public function confidence(): ?Confidence
    {
        return $this->confidence;
    }

    /**
     * Get the sentiment analysis
     *
     * @return Sentiment|null Sentiment analysis or null if not available
     */
    public function sentiment(): ?Sentiment
    {
        return $this->sentiment;
    }

    /**
     * Get detected content categories
     *
     * @return array<Category> List of categories
     */
    public function categories(): array
    {
        return $this->categories ?? [];
    }

    /**
     * Get the match collection
     *
     * @return MatchCollection|null Match collection or null if not available
     */
    public function matches(): ?MatchCollection
    {
        return $this->matches;
    }

    /**
     * Get the audience
     *
     * @return Audience|null Audience or null if not available
     */
    public function audience(): ?Audience
    {
        return $this->audience;
    }

    /**
     * Get the content type
     *
     * @return ContentType|null ContentType or null if not available
     */
    public function contentType(): ?ContentType
    {
        return $this->contentType;
    }

    /**
     * Clean text by masking offensive words
     *
     * @param string $text Text to clean
     * @param array<string> $words Words to mask
     * @return string Cleaned text
     */
    protected static function clean(string $text, array $words): string
    {
        /** @var string $replaceChar */
        $replaceChar = config('sentinel.mask_char', '*');

        foreach ($words as $word) {
            $text = str_replace($word, str_repeat($replaceChar, mb_strlen($word)), $text);
        }

        return $text;
    }
}
