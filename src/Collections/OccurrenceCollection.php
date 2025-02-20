<?php

namespace Ninja\Sentinel\Collections;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use Ninja\Sentinel\ValueObject\Position;

/**
 * @extends Collection<int, Position>
 */
final class OccurrenceCollection extends Collection
{
    /**
     * @param iterable<int, Position> $positions
     * @throws InvalidArgumentException
     */
    public function __construct(iterable $positions = [])
    {
        $this->validatePositions($positions);
        parent::__construct($positions);
    }

    /**
     * @param array<array{start: int, length: int}> $ranges
     * @return self<int, Position>
     */
    public static function fromRanges(array $ranges): self
    {
        /** @var array<int, Position> $positions */
        $positions = array_map(
            fn(array $range) => new Position($range['start'], $range['length']),
            $ranges,
        );

        return new self($positions);
    }

    public function density(int $totalLength): float
    {
        if (0 === $totalLength) {
            return 0.0;
        }

        /** @var int $totalMatched */
        $totalMatched = $this->sum(fn(Position $pos) => $pos->length());

        return (float) ($totalMatched / $totalLength);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function addPosition(Position $position): self
    {
        $this->validatePosition($position);
        $this->push($position);

        return $this;
    }

    public function ordered(): self
    {
        return $this->sortBy(fn(Position $pos) => $pos->start());
    }

    public function apply(string $text, string $replacement = '*'): string
    {
        $result = $text;
        $offset = 0;

        foreach ($this->ordered() as $position) {
            $replacementText = str_repeat($replacement, $position->length());
            $result = substr_replace(
                $result,
                $replacementText,
                $position->start() + $offset,
                $position->length(),
            );
        }

        return $result;
    }

    /**
     * @param OccurrenceCollection<int, Position> $items
     * @return self<int, Position>
     * @throws InvalidArgumentException
     */
    public function merge($items): self
    {
        if ($items instanceof OccurrenceCollection) {
            foreach ($items as $position) {
                $this->validatePosition($position);
            }
        }

        return parent::merge($items);
    }

    /**
     * @param iterable<int, Position> $positions
     * @throws InvalidArgumentException
     */
    private function validatePositions(iterable $positions): void
    {
        foreach ($positions as $position) {
            $this->validatePosition($position);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validatePosition(Position $newPosition): void
    {
        $hasOverlap = $this->contains(fn(Position $existing) => $existing->overlaps($newPosition));

        if ($hasOverlap) {
            throw new InvalidArgumentException('New position overlaps with existing positions');
        }
    }
}
