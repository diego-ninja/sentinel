<?php

namespace Ninja\Sentinel\Language\Rules\Fr;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final class AdverbRule implements Rule
{
    /**
     * @var array<int, string>
     */
    public array $adverbs = [
        "ainsi",
        "alors",
        "après",
        "assez",
        "aussi",
        "aujourd'hui",
        "autant",
        "autour",
        "avant",
        "beaucoup",
        "bien",
        "bientôt",
        "cependant",
        "certes",
        "chez",
        "combien",
        "comme",
        "comment",
        "dedans",
        "dehors",
        "déjà",
        "demain",
        "depuis",
        "derrière",
        "dessous",
        "dessus",
        "devant",
        "donc",
        "encore",
        "enfin",
        "ensemble",
        "ensuite",
        "environ",
        "ici",
        "jamais",
        "là",
        "loin",
        "longtemps",
        "lorsque",
        "maintenant",
        "mal",
        "mieux",
        "moins",
        "non",
        "où",
        "parfois",
        "partout",
        "peu",
        "plus",
        "plutôt",
        "pourquoi",
        "près",
        "presque",
        "puis",
        "quand",
        "quelquefois",
        "quoi",
        "sans",
        "soudain",
        "souvent",
        "tard",
        "tôt",
        "toujours",
        "tout",
        "très",
        "trop",
        "vite",
        "volontiers",
        "vraiment",
        "y",
    ];

    public function __invoke(string $word, Language $language): Collection
    {
        /** @var Collection<int, string> $variants */
        $variants = collect();

        if (in_array(mb_strtolower($word), $this->adverbs)) {
            $variants->push($word);
            return $variants;
        }

        // 1. Obtener la forma femenina del adjetivo
        $ultimaLetra = mb_substr($word, -1);
        if (in_array($ultimaLetra, ['e', 'i', 'u'])) {
            // Si termina en vocal, se usa la forma masculina
        } elseif ('o' === $ultimaLetra) {
            $word = mb_substr($word, 0, -1) . 'e';
        } elseif ('a' !== $ultimaLetra) {
            $word .= 'e';
        }

        // 2. Añadir "-ment" (con excepciones)
        if (str_ends_with($word, 'ant')) {
            $word = mb_substr($word, 0, -3) . 'amment';
        } elseif ('ent' === mb_substr($word, -3)) {
            $word = mb_substr($word, 0, -3) . 'emment';
        } else {
            $word .= 'ment';
        }

        $variants->push($word);

        /** @var Collection<int, string> $variants */
        return $variants;
    }

    public function name(): string
    {
        return 'adverb';
    }
}
