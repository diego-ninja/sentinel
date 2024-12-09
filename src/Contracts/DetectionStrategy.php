<?php

namespace Ninja\Censor\Contracts;

use Ninja\Censor\Collections\MatchCollection;

interface DetectionStrategy
{
    /**
     * @param  array<string>  $words
     */
    public function detect(string $text, iterable $words): MatchCollection;

    public function weight(): float;
}
