<?php

namespace Ninja\Sentinel\Analyzers\Contracts;

use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Result\Contracts\Result;

interface Analyzer
{
    /**
     * Check text for offensive content
     *
     * @param string $text The text to check
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result The analysis result
     */
    public function analyze(string $text, ?ContentType $contentType = null, ?Audience $audience = null): Result;
}
