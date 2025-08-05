<?php

namespace Ninja\Sentinel\Language\Rules\It;

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
        // Regla general: añadir "-ato"
        return $word . 'ato';
    }

    private function generateRegularGerund(string $word): string
    {
        // Regla general: añadir "-ando" o "-endo"
        return $word . 'ando';
    }
}
