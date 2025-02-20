<?php

namespace Ninja\Sentinel\Services\Adapters;

use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\ValueObject\Score;
use Ninja\Sentinel\ValueObject\Sentiment;

abstract readonly class AbstractAdapter implements ServiceAdapter
{
    protected function normalizeScore(float $value, float $min = 0.0, float $max = 1.0): float
    {
        if ($min === $max) {
            return $min;
        }

        return min(1.0, max(0.0, ($value - $min) / ($max - $min)));
    }

    /**
     * @param  array<array{offset: int, length: int}>  $ranges
     */
    protected function createOccurrences(array $ranges): OccurrenceCollection
    {
        return OccurrenceCollection::fromRanges(
            array_map(
                fn(array $range) => [
                    'start' => $range['offset'],
                    'length' => $range['length'],
                ],
                $ranges,
            ),
        );
    }

    /**
     * @param  array<string>  $categories
     * @return array<Category>
     */
    protected function createCategories(array $categories): array
    {
        return array_map(
            fn(string $category) => Category::from($category),
            $categories,
        );
    }

    protected function createSentiment(float $value): Sentiment
    {
        return Sentiment::withScore(new Score($value));
    }
}
