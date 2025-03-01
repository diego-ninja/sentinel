<?php

namespace Ninja\Sentinel\Context\Detectors;

use Ninja\Sentinel\Context\Enums\ContextType;

final readonly class WordSpecificContextDetector extends AbstractContextDetector
{
    /**
     * {@inheritdoc}
     */
    public function isInContext(string $fullText, string $word, int $position, array $words, string $language): bool
    {
        /** @var array<string, array<string>> $wordSpecificPatterns */
        $wordSpecificPatterns = $this->getContextCategory($language, 'word_specific_patterns');

        // Convert to lowercase for comparison
        $wordLower = mb_strtolower($word);

        // Some words are only offensive in certain contexts, check for safe patterns
        if ( ! isset($wordSpecificPatterns[$wordLower])) {
            return false;
        }

        foreach ($wordSpecificPatterns[$wordLower] as $pattern) {
            if (preg_match($pattern, $fullText)) {
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
        return ContextType::WordSpecific;
    }
}
