<?php

namespace Ninja\Sentinel\Language;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Enums\ContextType;
use Ninja\Sentinel\Language\Contracts\Context as ContextContract;

readonly class Context implements ContextContract
{
    /**
     * @param string[] $markers
     * @param string[] $whitelist
     */
    public function __construct(private ContextType $type, private array $markers, private array $whitelist) {}

    /** {@inheritDoc} */
    public function getContextType(): ContextType
    {
        return $this->type;
    }

    /** {@inheritDoc} */
    public function markers(): Collection
    {
        return new Collection($this->markers);
    }

    /** {@inheritDoc} */
    public function whitelist(): Collection
    {
        return new Collection($this->whitelist);
    }

    /** {@inheritDoc} */
    public function isSafe(string $fullText, string $word, int $position, array $words): bool
    {
        $contextWindow = 20;
        $start = max(0, $position - $contextWindow);
        $end = min(count($words) - 1, $position + $contextWindow);

        for ($i = $start; $i <= $end; $i++) {
            if ($i === $position) {
                continue;
            }

            $contextWord = mb_strtolower($words[$i]);
            if (in_array($contextWord, $this->markers)) {
                return true;
            }
        }

        return in_array(mb_strtolower($word), $this->whitelist);
    }
}
