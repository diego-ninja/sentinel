<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Detection\Contracts\DetectionStrategy;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

abstract class AbstractStrategy implements DetectionStrategy
{
    public const float STRATEGY_EFFICIENCY = 1.0;

    public function __construct(protected LanguageCollection $languages) {}

    public function efficiency(): float
    {
        return static::STRATEGY_EFFICIENCY;
    }
}
