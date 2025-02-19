<?php

namespace Ninja\Censor\ValueObject;

use InvalidArgumentException;
use Ninja\Censor\Collections\MatchCollection;

final readonly class Confidence
{
    public function __construct(private float $value)
    {
        $this->guard();
    }

    public static function calculate(MatchCollection $matches): self
    {
        if ($matches->isEmpty()) {
            return new self(0.0);
        }

        /** @var float $totalWeight */
        $totalWeight = $matches->sum(fn(Coincidence $match) => $match->type()->weight());

        return new self($totalWeight / count($matches));
    }

    public function value(): float
    {
        return $this->value;
    }

    private function guard(): void
    {
        if ($this->value < 0.0 || $this->value > 1.0) {
            throw new InvalidArgumentException('Confidence must be between 0.0 and 1.0');
        }
    }
}
