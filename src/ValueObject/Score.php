<?php

namespace Ninja\Censor\ValueObject;

use InvalidArgumentException;

final readonly class Score
{
    public function __construct(private float $value)
    {
        $this->guard();
    }

    public function value(): float
    {
        return $this->value;
    }

    private function guard(): void
    {
        if ($this->value < -1.0 || $this->value > 1.0) {
            throw new InvalidArgumentException('Score must be between -1.0 and 1.0');
        }
    }
}
