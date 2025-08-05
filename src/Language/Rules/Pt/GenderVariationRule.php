<?php

namespace Ninja\Sentinel\Language\Rules\Pt;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class GenderVariationRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();
        $lastChar = mb_substr($word, -1);
        $lastTwoChars = mb_substr($word, -2);

        if ('o' === $lastChar) {
            $variants->push(mb_substr($word, 0, -1) . 'a');
        }

        if (in_array($lastTwoChars, ['or', 'ês'])) {
            $variants->push($word . 'a'); // ej. "professor" -> "professora", "português" -> "portuguesa"
        }

        /** @var Collection<int, string> $variants */
        return $variants;
    }
    public function name(): string
    {
        return 'gender';
    }
}
