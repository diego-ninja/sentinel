<?php

namespace Ninja\Sentinel\Detection\Contracts;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Language\Language;

interface DetectionStrategy
{
    /**
     * @param string $text
     * @param Language|null $language
     * @return MatchCollection
     */
    public function detect(string $text, ?Language $language = null): MatchCollection;

    public function weight(): float;

    public function efficiency(): float;
}
