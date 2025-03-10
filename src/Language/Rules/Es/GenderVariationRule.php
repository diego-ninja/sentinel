<?php

namespace Ninja\Sentinel\Language\Rules\Es;

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

        if ('a' === $lastChar && ! in_array($lastTwoChars, ['ma','ta','pa'])) {  // Excepciones: el problema, el mapa, el poeta
            $variants[] = mb_substr($word, 0, -1) . 'o';
        }

        if (in_array($lastTwoChars, ['or', 'ón', 'és', 'án', 'ín', 'dor', 'tor', 'sor'])) { //Generalmente masculinos
            if ('n' === $lastChar || 'r' === $lastChar) { //Si termina en 'n' o 'r', agregamos la terminacion -a
                $variants[] = $word . 'a'; //ej. "doctor" -> "doctora", "bailarín" -> "bailarina"
            }
            if (in_array($lastTwoChars, ['ón', 'án', 'én', 'ín'])) { //Si termina en tilde, remover la tilde y agregar -a
                $variants[] = str_replace(['ón', 'án', 'én', 'ín'], ['on', 'an', 'en', 'in'], $word) . 'a';  // "campeón" -> "campeona"
            }
        }
        /** @var Collection<int, string> $variants */
        return $variants;
    }
    public function name(): string
    {
        return 'gender';
    }
}
