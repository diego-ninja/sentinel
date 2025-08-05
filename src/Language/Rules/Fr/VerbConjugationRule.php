<?php

namespace Ninja\Sentinel\Language\Rules\Fr;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class VerbConjugationRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();

        $variants->push($this->generateRegularParticiple($word));
        $variants->push($this->generateRegularGerund($word));

        /** @var Collection<int,string> $uniqueVariants */
        $uniqueVariants = $variants->unique()->values();
        return $uniqueVariants;
    }
    public function name(): string
    {
        return 'conjugation';
    }

    private function generateRegularParticiple(string $word): string
    {
        // Para verbos terminados en "-er": quitar "-er" y añadir "-é"
        if (mb_substr($word, -2) === 'er') {
            return mb_substr($word, 0, -2) . 'é';
        }
        // Regla general: añadir "-é"
        return $word . 'é';
    }

    private function generateRegularGerund(string $word): string
    {
        // Para verbos terminados en "-er": quitar "-er" y añadir "-ant"
        if (mb_substr($word, -2) === 'er') {
            $stem = mb_substr($word, 0, -2);
            // Verbos terminados en "-ger": añadir "e" antes de "-ant"
            if (mb_substr($stem, -1) === 'g') {
                return $stem . 'eant';
            }
            return $stem . 'ant';
        }
        // Regla general: añadir "-ant"
        return $word . 'ant';
    }
}
