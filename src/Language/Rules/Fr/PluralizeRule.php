<?php

namespace Ninja\Sentinel\Language\Rules\Fr;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class PluralizeRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();
        $variants->push($word . 's');

        // Palabras que terminan en "-au", "-eau", "-eu": añadir "-x"
        if (in_array(mb_substr($word, -2), ['au', 'eu']) || 'eau' === mb_substr($word, -3)) {
            $variants->push(mb_substr($word, 0) . 'x');
        }

        /** @var Collection<int, string> $variants */
        return $variants->unique();
    }
    public function name(): string
    {
        return 'pluralize';
    }
}
