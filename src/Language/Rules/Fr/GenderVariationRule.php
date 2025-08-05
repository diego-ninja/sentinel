<?php

namespace Ninja\Sentinel\Language\Rules\Fr;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class GenderVariationRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();
        $lastTwoChars = mb_substr($word, -2);

        // Regla general: añadir "-e"
        $variants->push($word . 'e');

        // Casos especiales
        if (in_array($lastTwoChars, ['er', 'if'])) {
            $variants->push(mb_substr($word, 0, -2) . 'ère'); // ej. "boulanger" -> "boulangère"
            $variants->push(mb_substr($word, 0, -2) . 'ive'); // ej. "actif" -> "active"
        }

        /** @var Collection<int, string> $variants */
        return $variants;
    }
    public function name(): string
    {
        return 'gender';
    }
}
