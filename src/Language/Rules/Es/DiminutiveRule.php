<?php

namespace Ninja\Sentinel\Language\Rules\Es;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class DiminutiveRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();
        $lastChar = mb_substr($word, -1);
        $lastTwoChars = mb_substr($word, -2);
        $base = in_array($lastChar, ['a', 'e', 'i', 'o', 'u'], true) ? mb_substr($word, 0, -1) : $word;

        // Cambios ortográficos
        $base = str_replace(
            ['za', 'zo', 'ca', 'co', 'ga', 'go', 'gua', 'guo', 'z'],
            ['c', 'c', 'qu', 'qu', 'gu', 'gu', 'gü', 'gü', 'c'],
            $base,
        );

        // Terminaciones comunes
        $variants->push(
            $base . 'ito',
            $base . 'ita',
            $base . 'illo',
            $base . 'illa',
        );

        // Terminaciones con diptongo
        if (in_array($lastTwoChars, ['io', 'ia', 'ua', 'uo', 'ue', 'ei'])) {
            $variants->push(
                $word . 'cito',
                $word . 'cita',
                $word . 'uelo',
                $word . 'uela',
            );
        } else {
            $variants->push(
                $base . 'uelo',
                $base . 'uela',
            );
        }

        /** @var Collection<int, string> $variants */
        return $variants->unique();
    }
    public function name(): string
    {
        return 'diminutive';
    }
}
