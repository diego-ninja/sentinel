<?php

namespace Ninja\Sentinel\Context\Contracts;

use Ninja\Sentinel\Context\Enums\ContextType;

interface ContextDetector
{
    /**
     * Checks if a word appears in a safe context of the detector's type
     *
     * @param string $fullText Complete text being analyzed
     * @param string $word The potentially offensive word
     * @param int $position Position of the word in the text array
     * @param array<string> $words All words in the text
     * @param string $language Current language code
     * @return bool True if the word is in a safe context
     */
    public function isInContext(string $fullText, string $word, int $position, array $words, string $language): bool;

    /**
     * Returns the identifier for this context type
     *
     * @return ContextType The context type identifier
     */
    public function getContextType(): ContextType;
}