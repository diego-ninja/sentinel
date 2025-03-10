<?php

namespace Ninja\Sentinel\Language\Rules\It;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class GenderVariationRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();
        $lastChar = mb_substr($word, -1);

        if ('o' === $lastChar || 'e' === $lastChar) {
            $variants->push(mb_substr($word, 0, -1) . 'a');
        }

        /** @var Collection<int, string> $variants */
        return $variants;
    }
    public function name(): string
    {
        return 'gender';
    }
}
