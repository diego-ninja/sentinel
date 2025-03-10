<?php

namespace Ninja\Sentinel\Language\Rules\It;

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

        // "-o" o "-a" a "-i"
        if (in_array($lastChar, ['o', 'a'])) {
            $variants->push(mb_substr($word, 0, -1) . 'i');
        }

        // "-e" a "-i"
        if ('e' === $lastChar) {
            $variants->push(mb_substr($word, 0, -1) . 'i');
        }

        return $variants->unique();
    }
    public function name(): string
    {
        return 'pluralize';
    }
}
