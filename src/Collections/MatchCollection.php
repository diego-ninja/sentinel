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
    public function addCoincidence(Coincidence $coincidence): void
    {
        if ($this->contains($coincidence)) {
            return;
        }

        $this->add($coincidence);
    }

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

        return $this->isNotEmpty() && ($this->score($text)->value() >= $threshold);
    }

    /**
     * @return array<string>
     */
    public function words(): array
    {
        // @phpstan-ignore return.type
        return $this->map(fn (Coincidence $match) => $match->word())->toArray();
    }

    /**
     * @param  MatchCollection  $items
     */
    public function merge($items): self
    {
        foreach ($items as $item) {
            if (! $this->contains(fn (Coincidence $existingItem) => $existingItem->word() === $item->word())) {
                $this->add($item);
            }
        }

        return $this;
    }

    public function clean(string $text): string
    {
        if ($this->isEmpty()) {
            return $text;
        }

        /** @var array<array{start: int, length: int}> $positions */
        $positions = [];

        foreach ($this as $match) {
            $pos = mb_stripos($text, $match->word());
            if ($pos !== false) {
                $positions[] = [
                    'start' => $pos,
                    'length' => mb_strlen($match->word()),
                ];
            }
        }

        usort($positions, function ($a, $b) {
            if ($a['start'] === $b['start']) {
                return $b['length'] - $a['length'];
            }

            return $a['start'] - $b['start'];
        });

        $result = $text;
        $offset = 0;

        foreach ($positions as $position) {
            /** @var string $replacer */
            $replacer = config('censor.mask_char', '*');
            $replacement = str_repeat($replacer, $position['length']);
            $result = mb_substr($result, 0, $position['start'] - $offset)
                .$replacement
                .mb_substr($result, $position['start'] - $offset + $position['length']);
        }

        return $result;
    }
}
