<?php

namespace Ninja\Censor\ValueObject;

use InvalidArgumentException;
use Ninja\Censor\Collections\MatchCollection;

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
        if ($this->value < 0.0 || $this->value > 1.0) {
            throw new InvalidArgumentException('Score must be between 0.0 and 1.0');
        }
    }

    public static function calculate(MatchCollection $matches, string $text): self
    {
        if ($matches->isEmpty()) {
            return new self(0.0);
        }

        $totalWords = count(explode(' ', $text));
        $offensiveWords = 0;
        $weightedScore = 0.0;
        $coveredWords = [];

        foreach ($matches as $match) {
            $words = explode(' ', $match->word);
            $newWords = array_diff($words, $coveredWords);
            if (empty($newWords)) {
                continue;
            }

            $coveredWords = array_merge($coveredWords, $words);
            $typeWeight = $match->type->weight();
            $lengthMultiplier = count($words) > 1 ? 1.2 : 1.0;
            $weightedScore += $typeWeight * $lengthMultiplier * count($words);
            $offensiveWords += count($words);
        }

        if ($offensiveWords === 0) {
            return new self(0.0);
        }

        $baseScore = $weightedScore / max($totalWords, 1);
        $densityMultiplier = min(1.5, 1 + ($offensiveWords / max($totalWords, 1)));

        return new self(min(1.0, $baseScore * $densityMultiplier));
    }
}
