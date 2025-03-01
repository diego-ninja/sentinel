<?php

namespace Ninja\Sentinel\Context\Detectors;

use Ninja\Sentinel\Context\Enums\ContextType;

final readonly class TechnicalContextDetector extends AbstractContextDetector
{

    /**
     * {@inheritdoc}
     */
    public function isInContext(string $fullText, string $word, int $position, array $words, string $language): bool
    {
        /** @var array<string> $safeTechnicalTerms */
        $safeTechnicalTerms = $this->getContextCategory($language, 'safe_technical_terms');

        // Check if the word is in our technical safe list for specific domains
        return in_array(mb_strtolower($word), $safeTechnicalTerms);
    }

    /**
     * {@inheritdoc}
     */
    public function getContextType(): ContextType
    {
        return ContextType::Technical;
    }
}
