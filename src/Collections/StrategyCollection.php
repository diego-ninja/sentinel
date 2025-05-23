<?php

namespace Ninja\Sentinel\Collections;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Detection\Contracts\DetectionStrategy;

/**
 * @extends Collection<int, DetectionStrategy>
 */
final class StrategyCollection extends Collection implements DetectionStrategy
{
    public function addStrategy(DetectionStrategy $strategy): void
    {
        if ($this->contains($strategy)) {
            return;
        }

        $this->add($strategy);
        $this->orderByWeight();
    }

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();

        foreach ($this->all() as $strategy) {
            /** @var DetectionStrategy $strategy */
            $matches = $matches->merge($strategy->detect($text, $words));
        }

        return $matches;
    }

    public function weight(): float
    {
        /** @var float $totalWeight */
        $totalWeight = $this->sum(fn(DetectionStrategy $strategy) => $strategy->weight());
        $totalStrategies = $this->count();

        return $totalWeight / $totalStrategies;
    }

    private function orderByWeight(): void
    {
        $sorted = $this->sortByDesc(fn(DetectionStrategy $strategy) => $strategy->weight());
        $this->items = $sorted->values()->all();
    }
}
