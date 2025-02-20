<?php

namespace Ninja\Sentinel\Detection\Contracts;

use Ninja\Sentinel\Collections\MatchCollection;

interface DetectionStrategy
{
    /**
     * @param  array<string>  $words
     */
    public function detect(string $text, iterable $words): MatchCollection;

    public function weight(): float;
}
