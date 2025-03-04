<?php

namespace Ninja\Sentinel\Language\Contracts;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Enums\ContextType;

interface Context
{
    /**
     * Returns the list of markers for this language
     *
     * @return Collection<int, string>
     */
    public function markers(): Collection;

    /**
     * Returns the list of words that are safe in this language
     *
     * @return Collection<int, string>
     */
    public function whitelist(): Collection;

    /**
     * Checks if a word is safe in the current language
     *
     * @param string $fullText Complete text being analyzed
     * @param string $word The potentially offensive word
     * @param int $position Position of the word in the text array
     * @param array<string> $words All words in the text
     * @return bool True if the word is in a safe language
     */
    public function isSafe(string $fullText, string $word, int $position, array $words): bool;

    /**
     * Returns the identifier for this language type
     *
     * @return ContextType The language type identifier
     */
    public function getContextType(): ContextType;

}