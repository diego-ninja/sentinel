<?php

namespace Ninja\Censor\Collections;

use Illuminate\Support\Collection;
use Ninja\Censor\ValueObject\Coincidence;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

/**
 * @extends Collection<int, Coincidence>
 */
class MatchCollection extends Collection
{
    public function score(string $text): Score
    {
        return Score::calculate($this, $text);
    }

    public function confidence(): Confidence
    {
        return Confidence::calculate($this);
    }

    public function offensive(string $text): bool
    {
        /** @var float $threshold */
        $threshold = config('censor.threshold_score', 0.5);
        return $this->isNotEmpty() && $this->score($text)->value() > $threshold;
    }

    public function clean($text): string
    {
        return $this->reduce(
            fn (string $text, Coincidence $match) => $match->clean($text),
            $text
        );
    }
}