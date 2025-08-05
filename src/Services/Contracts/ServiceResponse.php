<?php

namespace Ninja\Sentinel\Services\Contracts;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

interface ServiceResponse
{
    public function original(): string;

    public function replaced(): ?string;

    public function matches(): ?MatchCollection;

    public function score(): ?Score;

    public function confidence(): ?Confidence;

    /** @return array<Category>|null */
    public function categories(): ?array;

    public function sentiment(): ?Sentiment;
    public function language(): LanguageCode;
}
