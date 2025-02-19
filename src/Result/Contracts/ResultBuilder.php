<?php

namespace Ninja\Censor\Result\Contracts;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Enums\Category;
use Ninja\Censor\Result\Result;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;
use Ninja\Censor\ValueObject\Sentiment;

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

    public function build(): Result;
}
