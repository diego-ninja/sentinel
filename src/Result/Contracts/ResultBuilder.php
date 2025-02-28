<?php

namespace Ninja\Sentinel\Result\Contracts;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Result\Result;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

interface ResultBuilder
{
    public function withOriginalText(string $text): self;

    public function withOffensive(bool $offensive): self;

    /**
     * @param  array<string>  $words
     */
    public function withWords(array $words): self;

    public function withReplaced(string $replaced): self;

    public function withScore(?Score $score): self;

    public function withConfidence(?Confidence $confidence): self;

    public function withSentiment(?Sentiment $sentiment): self;

    /**
     * @param  array<Category>|null  $categories
     */
    public function withCategories(?array $categories): self;

    public function withMatches(MatchCollection $matches): self;

    public function withAudience(?Audience $audience): self;

    public function withContentType(?ContentType $contentType): self;

    public function build(): Result;
}
