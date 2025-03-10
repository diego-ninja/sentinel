<?php

namespace Ninja\Sentinel\Language\Rules\Pt;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class PluralizeRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        /** @var Collection<int, string> $variants */
        $variants = collect();
        $lastChar = mb_substr($word, -1);

        // Terminaciones en vocal: añadir "-s"
        if (in_array($lastChar, ['a', 'e', 'i', 'o', 'u'])) {
            $variants->push($word . 's');
        }

        // Terminaciones en consonante: añadir "-es"
        if ( ! in_array($lastChar, ['a', 'e', 'i', 'o', 'u'])) {
            $variants->push($word . 'es');
        }

        // Terminaciones en "-ão": "-ões", "-ães", "-ãos"
        if ('ão' === mb_substr($word, -2)) {
            $variants->push(mb_substr($word, 0, -2) . 'ões');
            $variants->push(mb_substr($word, 0, -2) . 'ães');
            $variants->push(mb_substr($word, 0, -2) . 'ãos');
        }

        /** @var Collection<int, string> $variants */
        return $variants->unique();
    }
    public function name(): string
    {
        return 'pluralize';
    }
}
