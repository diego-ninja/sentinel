<?php

namespace Ninja\Sentinel\Language\Contracts;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Enums\ContextType;

interface Context
{
    /**
     * Returns the list of markers for this language.
     *
     * @return Collection<int, string>
     */
    public function markers(): Collection;

    /**
     * Returns the list of words that are safe in this language.
     *
     * @return Collection<int, string>
     */
    public function whitelist(): Collection;

    /**
     * Checks if a word is safe in the current context.
     *
     * @param string $fullText Complete text being analyzed
     * @param string $word The potentially offensive word found in the text
     * @param string $offensiveRoot The base offensive word from the dictionary that caused the match
     * @param int $position Position of the word in the text array
     * @param array<string> $words All words in the text
     * @return bool True if the word is in a safe context
     */
    public function isSafe(string $fullText, string $word, string $offensiveRoot, int $position, array $words): bool;

    /**
     * Returns the identifier for this context type.
     *
     * @return ContextType The context type identifier
     */
    public function getContextType(): ContextType;
}