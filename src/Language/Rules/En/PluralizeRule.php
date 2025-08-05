<?php

namespace Ninja\Sentinel\Language\Rules\En;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class PluralizeRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();
        $lastChar = mb_substr($word, -1);
        $lastTwoChars = mb_substr($word, -2);

        // Plurales irregulares
        $irregulars = [
            'child' => 'children',
            'mouse' => 'mice',
            'foot' => 'feet',
            'tooth' => 'teeth',
            'man' => 'men',
            'woman' => 'women',
            'goose' => 'geese',
            'person' => 'people'
        ];

        if (isset($irregulars[$word])) {
            $variants->push($irregulars[$word]);
        }

        // Regla general: añadir "-s"
        $variants->push($word . 's');

        // Palabras que terminan en "-y" precedida de consonante: cambiar "-y" a "-ies"
        if ('y' === $lastChar && ! in_array(mb_substr($word, -2, 1), ['a', 'e', 'i', 'o', 'u'])) {
            $variants->push(mb_substr($word, 0, -1) . 'ies');
        }

        // Palabras que terminan en "-s", "-ss", "-sh", "-ch", "-x", "-z": añadir "-es"
        if (in_array($lastTwoChars, ['ss', 'sh', 'ch']) || in_array($lastChar, ['s', 'x', 'z'])) {
            $variants->push($word . 'es');
        }

        // Palabras que terminan en "-o" precedida de consonante: añadir "-es"
        if ('o' === $lastChar && ! in_array(mb_substr($word, -2, 1), ['a', 'e', 'i', 'o', 'u'])) {
            $variants->push($word . 'es');
        }

        // Palabras que terminan en "-f" o "-fe": cambiar a "-ves"
        if ('f' === $lastChar) {
            $variants->push(mb_substr($word, 0, -1) . 'ves');
        } elseif ('fe' === $lastTwoChars) {
            $variants->push(mb_substr($word, 0, -2) . 'ves');
        }

        /** @var Collection<int, string> $variants */
        return $variants->unique();
    }
    public function name(): string
    {
        return 'pluralize';
    }
}
