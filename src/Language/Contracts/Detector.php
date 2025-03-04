<?php

namespace Ninja\Sentinel\Language\Contracts;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\DTO\DetectionResult;

interface Detector
{
    /**
     * Detects the language of a given text
     *
     * @param string $text The text to analyze
     * @return Collection<int, Language|Context|DetectionResult> The detected languages or contexts
     */
    public function detect(string $text): Collection;
}