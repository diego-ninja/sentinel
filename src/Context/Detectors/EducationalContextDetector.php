<?php

namespace Ninja\Sentinel\Context\Detectors;

use Ninja\Sentinel\Context\Enums\ContextType;

/**
 * Detector for educational/academic contexts that may contain legitimate uses of potentially offensive words
 */
final readonly class EducationalContextDetector extends AbstractContextDetector
{

    /**
     * {@inheritdoc}
     */
    public function isInContext(string $fullText, string $word, int $position, array $words, string $language): bool
    {
        /** @var array<string> $educationalMarkers */
        $educationalMarkers = $this->getContextCategory($language, 'educational_context');

        // Check for educational markers in nearby words
        $contextWindow = 10; // Look 10 words before and after
        $start = max(0, $position - $contextWindow);
        $end = min(count($words) - 1, $position + $contextWindow);

        for ($i = $start; $i <= $end; $i++) {
            if ($i === $position) {
                continue;
            } // Skip the word itself

            $contextWord = mb_strtolower($words[$i]);
            if (in_array($contextWord, $educationalMarkers)) {
                return true;
            }
        }

        /** @var array<string> $safeEducationalTerms */
        $safeEducationalTerms = $this->getContextCategory($language, 'safe_educational_terms');
        return in_array(mb_strtolower($word), $safeEducationalTerms);
    }

    /**
     * {@inheritdoc}
     */
    public function getContextType(): ContextType
    {
        return ContextType::Educational;
    }
}
