<?php

namespace Ninja\Sentinel\Context\Detectors;

use Ninja\Sentinel\Context\Enums\ContextType;

final readonly class QuotedContextDetector extends AbstractContextDetector
{

    /**
     * Common quote markers across languages
     *
     * @var array<string>
     */
    private const array MARKERS = ['"', "'", '"', '"', '«', '»', '\'', '\''];

    /**
     * {@inheritdoc}
     */
    public function isInContext(string $fullText, string $word, int $position, array $words, string $language): bool
    {
        // Look for quote markers in the full text
        foreach (self::MARKERS as $marker) {
            // Check if word is between quotes
            $pattern = '/' . preg_quote($marker, '/') . '.*\b' . preg_quote($words[$position], '/') .
                '\b.*' . preg_quote($marker, '/') . '/ui';
            if (preg_match($pattern, $fullText)) {
                return true;
            }
        }

        /** @var array<string> $quoteVerbs */
        $quoteVerbs = $this->getContextCategory($language, 'quote_words');

        // Check for quote attribution verbs before the position
        for ($i = max(0, $position - 3); $i < $position; $i++) {
            $contextWord = mb_strtolower($words[$i]);
            if (in_array($contextWord, $quoteVerbs)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getContextType(): ContextType
    {
        return ContextType::Quoted;
    }
}
