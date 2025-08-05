<?php

namespace Ninja\Sentinel\Language\Rules\Es;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class AugmentativeRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();
        $lastChar = mb_substr($word, -1);
        $lastTwoChars = mb_substr($word, -2);
        $base = in_array($lastChar, ['a', 'e', 'i', 'o', 'u'], true) ? mb_substr($word, 0, -1) : $word;

        if (in_array($lastTwoChars, ['za', 'zo', 'ca', 'co', 'ga', 'go'])) {
            $base = str_replace(['za', 'zo', 'ca', 'co', 'ga', 'go'], ['z', 'z', 'qu', 'qu', 'gu', 'gu'], $base);
        }

        $variants->push(
            $base . 'ón',
            $base . 'ona',
            $base . 'azo',
            $base . 'aza',
            $base . 'ote',
            $base . 'ota',
        );

        /** @var Collection<int, string> $variants */
        return $variants->unique();
    }
    public function name(): string
    {
        return 'augmentative';
    }
}
