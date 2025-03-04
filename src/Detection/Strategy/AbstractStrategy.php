<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Detection\Contracts\DetectionStrategy;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

abstract class AbstractStrategy implements DetectionStrategy
{
    public function __construct(protected LanguageCollection $languages) {}
}
