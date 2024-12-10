<?php

namespace Ninja\Censor\Enums;

enum SentimentType: string
{
    case Positive = 'positive';
    case Negative = 'negative';
    case Neutral = 'neutral';
    case Mixed = 'mixed';
    case Unknown = 'unknown';

    public function threshold(): float
    {
        return match ($this) {
            self::Positive => 0.2,
            self::Negative => -0.2,
            self::Neutral,
            self::Mixed,
            self::Unknown => 0.0,
        };
    }

    public function equals(SentimentType $type): bool
    {
        return $this->value === $type->value;
    }
}
