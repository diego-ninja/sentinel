<?php

namespace Ninja\Censor\Contracts;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Result\AbstractResult;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

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

    /**
     * @param  array<string>|null  $categories
     */
    public function withCategories(?array $categories): self;

    public function withMatches(MatchCollection $matches): self;

    public function build(): AbstractResult;
}
