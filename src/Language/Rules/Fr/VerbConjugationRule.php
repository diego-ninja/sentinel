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

        return $variants->unique();
    }
    public function name(): string
    {
        return 'conjugation';
    }

    private function generateRegularParticiple(string $word): string
    {
        // Regla general: añadir "-é"
        return $word . 'é';
    }

    private function generateRegularGerund(string $word): string
    {
        // Regla general: añadir "-ant"
        return $word . 'ant';
    }
}
