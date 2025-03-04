<?php

namespace Ninja\Sentinel\Collections;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Support\ThresholdManager;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Score;

/**
 * @extends Collection<int, Coincidence>
 */
class MatchCollection extends Collection
{
    /**
     * Add a coincidence to the collection if it doesn't already exist
     *
     * @param Coincidence $coincidence The coincidence to add
     * @return void
     */
    public function addCoincidence(Coincidence $coincidence): void
    {
        if ( ! $this->contains(fn(Coincidence $existingItem) => $existingItem->word() === $coincidence->word())) {
            $this->add($coincidence);
        }
    }

    /**
     * Calculate the overall score for this collection of matches
     *
     * @return Score The calculated score
     */
    public function score(): Score
    {
        if ($this->isEmpty()) {
            return new Score(0.0);
        }

        /** @var float $totalPositive */
        $totalPositive = $this
            ->filter(fn(Coincidence $match) => $match->score()->value() > 0)
            ->sum(fn(Coincidence $match) => $match->score()->value());

        /** @var float $totalNegative */
        $totalNegative = $this
            ->filter(fn(Coincidence $match) => $match->score()->value() < 0)
            ->sum(fn(Coincidence $match) => $match->score()->value());

        // Apply negative scores (from safe contexts) to reduce the overall score
        $finalScore = max(0.0, $totalPositive + $totalNegative);

        return new Score(min(1.0, $finalScore));
    }

    /**
     * Calculate the confidence level for this collection of matches
     *
     * @return Confidence The calculated confidence
     */
    public function confidence(): Confidence
    {
        if ($this->isEmpty()) {
            return new Confidence(0.0);
        }

        return new Confidence(
            (float) $this->average(fn(Coincidence $match) => $match->confidence()->value()),
        );
    }

    /**
     * Determine if the text is offensive based on matches and language
     *
     * @param string|null $text Original text being analyzed
     * @param array<Category>|null $categories Categories detected in the content
     * @param ContentType|null $contentType Type of content being analyzed
     * @param Audience|null $audience Target audience for the content
     * @return bool True if the content is considered offensive
     */
    public function offensive(
        ?string      $text = null,
        ?array       $categories = null,
        ?ContentType $contentType = null,
        ?Audience    $audience = null,
    ): bool {
        // Get the appropriate threshold based on language
        $threshold = ThresholdManager::getThreshold(
            $categories ?? [],
            $contentType,
            $audience,
        );

        return $this->isNotEmpty() && ($this->score()->value() >= $threshold);
    }

    /**
     * Get a list of detected offensive words
     *
     * @return array<string> List of offensive words
     */
    public function words(): array
    {
        // @phpstan-ignore return.type
        return $this->map(fn(Coincidence $match) => $match->word())->toArray();
    }

    /**
     * Merge another collection of matches
     *
     * @param  MatchCollection  $items Collection to merge
     * @return self New collection with merged items
     */
    public function merge($items): self
    {
        foreach ($items as $item) {
            if ( ! $this->contains(fn(Coincidence $existingItem) => $existingItem->word() === $item->word())) {
                $this->add($item);
            }
        }

        return $this;
    }

    /**
     * Clean text by masking offensive words
     *
     * @param string $text Text to clean
     * @return string Cleaned text
     */
    public function clean(string $text): string
    {
        if ($this->isEmpty()) {
            return $text;
        }

        /** @var array<array{start: int, length: int}> $positions */
        $positions = [];

        foreach ($this as $match) {
            $pos = 0;
            while (($pos = mb_stripos($text, $match->word(), $pos)) !== false) {
                $positions[] = [
                    'start' => $pos,
                    'length' => mb_strlen($match->word()),
                ];
                $pos += mb_strlen($match->word());
            }
        }

        usort($positions, fn($a, $b) => $b['start'] - $a['start']);

        $result = $text;
        /** @var string $replacer */
        $replacer = config('sentinel.mask_char', '*');

        foreach ($positions as $position) {
            $replacement = str_repeat($replacer, $position['length']);
            $result = mb_substr($result, 0, $position['start']) .
                $replacement .
                mb_substr($result, $position['start'] + $position['length']);
        }

        return $result;
    }
}
