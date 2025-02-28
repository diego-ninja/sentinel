<?php

namespace Ninja\Sentinel\Result\Contracts;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

interface Result
{
    public function offensive(): bool;

    /**
     * @return string[]
     */
    public function words(): array;

    public function replaced(): string;

    public function original(): string;

    public function score(): ?Score;

    public function confidence(): ?Confidence;

    public function sentiment(): ?Sentiment;

    public function audience(): ?Audience;

    public function contentType(): ?ContentType;

    /**
     * @return Category[]
     */
    public function categories(): array;

    public function matches(): ?MatchCollection;
}
