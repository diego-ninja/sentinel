<?php

namespace Ninja\Sentinel\Language\Rules\Es;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final readonly class PluralizeRule implements Rule
{
    public function __invoke(string $word, Language $language): Collection
    {
        $variants = collect();

        // Terminaciones en vocal (incluyendo "-y")
        if ($this->endsWithVowel($word)) {
            $variants->push($word . 's');
        }

        // Terminación en "-z"
        if ('z' === mb_substr($word, -1)) {
            $variants->push(mb_substr($word, 0, -1) . 'ces');
        }

        // Terminaciones en "-s", "-x" (sin ser "-as", "-es", "-is", "-os", "-us")
        if ($this->endsWithS_X($word) && ! $this->endsWithCommonPlural($word)) {
            $variants->push($word . 'es');
        }

        // Palabras acentuadas en la última sílaba
        if ($this->endsWithAccentedVowel($word)) {
            $variants->push($word . 'es');
            $variants->push($this->removeAccent($word) . 's');
        }

        // Palabras terminadas en "-n", "-r" o con acento en la penúltima sílaba
        if ($this->endsWithN_R($word) || $this->endsWithAccentedPenultimate($word)) {
            $variants->push($word . 'es');
            if ($this->endsWithAccentedPenultimate($word)) {
                $variants->push($this->removeAccent($word) . 'es');
            }
        }

        /** @var Collection<int, string> $variants */
        return $variants->unique();
    }
    public function name(): string
    {
        return 'pluralize';
    }

    private function endsWithVowel(string $word): bool
    {
        $vowels = ['a', 'e', 'i', 'o', 'u', 'á', 'é', 'í', 'ó', 'ú', 'y'];
        return in_array(mb_substr($word, -1), $vowels, true);
    }

    private function endsWithS_X(string $word): bool
    {
        $lastChar = mb_substr($word, -1);
        return in_array($lastChar, ['s', 'x'], true);
    }

    private function endsWithCommonPlural(string $word): bool
    {
        $pluralEndings = ['as', 'es', 'is', 'os', 'us', 'ás', 'és', 'ís', 'ós', 'ús'];
        return in_array(mb_substr($word, -2), $pluralEndings, true);
    }

    private function endsWithAccentedVowel(string $word): bool
    {
        $accentedVowels = ['í', 'ú'];
        return in_array(mb_substr($word, -1), $accentedVowels, true);
    }

    private function removeAccent(string $word): string
    {
        return str_replace(['í', 'ú', 'ón', 'án', 'én', 'ín'], ['i', 'u', 'on', 'an', 'en', 'in'], $word);
    }

    private function endsWithN_R(string $word): bool
    {
        $lastChar = mb_substr($word, -1);
        return in_array($lastChar, ['n', 'r'], true);
    }

    private function endsWithAccentedPenultimate(string $word): bool
    {
        $accentedPenultimateEndings = ['ón', 'án', 'én', 'ín', 'ún'];
        return in_array(mb_substr($word, -2), $accentedPenultimateEndings, true);
    }
}
