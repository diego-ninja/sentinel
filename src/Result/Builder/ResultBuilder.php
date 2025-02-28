<?php

namespace Ninja\Sentinel\Result\Builder;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Result\Contracts\ResultBuilder as ResultBuilderContract;
use Ninja\Sentinel\Result\Result;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

final class ResultBuilder implements ResultBuilderContract
{
    /**
     * The original text being analyzed
     */
    private string $original = '';

    /**
     * Whether the content is offensive
     */
    private bool $offensive = false;

    /**
     * List of offensive words found
     *
     * @var array<string>
     */
    private array $words = [];

    /**
     * Cleaned text with offensive content masked
     */
    private string $replaced = '';

    /**
     * Content score
     */
    private ?Score $score = null;

    /**
     * Confidence level
     */
    private ?Confidence $confidence = null;

    /**
     * Sentiment analysis
     */
    private ?Sentiment $sentiment = null;

    /**
     * Detected content categories
     *
     * @var array<Category>|null
     */
    private ?array $categories = null;

    /**
     * Collection of matches
     */
    private ?MatchCollection $matches = null;

    /**
     * Type of content being analyzed
     */
    private ?ContentType $contentType = null;

    /**
     * Target audience for content
     */
    private ?Audience $audience = null;

    /**
     * Set the original text
     *
     * @param string $text Original text
     * @return self Builder instance
     */
    public function withOriginalText(string $text): self
    {
        $clone = clone $this;
        $clone->original = $text;
        $clone->replaced = $text;

        return $clone;
    }

    /**
     * Build the Result object
     *
     * @return Result Constructed Result instance
     */
    public function build(): Result
    {
        return new Result(
            offensive: $this->offensive,
            words: $this->words,
            replaced: $this->replaced,
            original: $this->original,
            matches: $this->matches,
            score: $this->score,
            confidence: $this->confidence,
            sentiment: $this->sentiment,
            categories: $this->categories,
            contentType: $this->contentType,
            audience: $this->audience,
        );
    }

    /**
     * Set whether content is offensive
     *
     * @param bool $offensive Whether content is offensive
     * @return ResultBuilderContract Builder instance
     */
    public function withOffensive(bool $offensive): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->offensive = $offensive;

        return $clone;
    }

    /**
     * Set list of offensive words
     *
     * @param array<string> $words Offensive words
     * @return ResultBuilderContract Builder instance
     */
    public function withWords(array $words): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->words = $words;

        return $clone;
    }

    /**
     * Set cleaned text
     *
     * @param string $replaced Cleaned text
     * @return ResultBuilderContract Builder instance
     */
    public function withReplaced(string $replaced): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->replaced = $replaced;

        return $clone;
    }

    /**
     * Set content score
     *
     * @param Score|null $score Content score
     * @return ResultBuilderContract Builder instance
     */
    public function withScore(?Score $score): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->score = $score;

        return $clone;
    }

    /**
     * Set confidence level
     *
     * @param Confidence|null $confidence Confidence level
     * @return ResultBuilderContract Builder instance
     */
    public function withConfidence(?Confidence $confidence): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->confidence = $confidence;

        return $clone;
    }

    /**
     * Set sentiment analysis
     *
     * @param Sentiment|null $sentiment Sentiment analysis
     * @return ResultBuilderContract Builder instance
     */
    public function withSentiment(?Sentiment $sentiment): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->sentiment = $sentiment;

        return $clone;
    }

    /**
     * Set detected content categories
     *
     * @param array<Category>|null $categories Content categories
     * @return ResultBuilderContract Builder instance
     */
    public function withCategories(?array $categories): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->categories = $categories;

        return $clone;
    }

    /**
     * Set match collection
     *
     * @param MatchCollection $matches Match collection
     * @return ResultBuilderContract Builder instance
     */
    public function withMatches(MatchCollection $matches): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->matches = $matches;

        return $clone;
    }

    /**
     * Set content type
     *
     * @param ContentType|null $contentType Content type
     * @return ResultBuilderContract Builder instance
     */
    public function withContentType(?ContentType $contentType): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->contentType = $contentType;

        return $clone;
    }

    /**
     * Set audience type
     *
     * @param Audience|null $audience Audience type
     * @return ResultBuilderContract Builder instance
     */
    public function withAudience(?Audience $audience): ResultBuilderContract
    {
        $clone = clone $this;
        $clone->audience = $audience;

        return $clone;
    }
}