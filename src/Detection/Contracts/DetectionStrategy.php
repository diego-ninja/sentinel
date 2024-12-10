<?php

namespace Ninja\Censor\Detection\Contracts;

use Ninja\Censor\Collections\MatchCollection;

interface DetectionStrategy
{
    /**
     * @param  array<string>  $words
     */
    public function detect(string $text, iterable $words): MatchCollection;

    public function weight(): float;
}
