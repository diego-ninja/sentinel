<?php

namespace Ninja\Sentinel\Language\Rules\Es;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final class AdverbRule implements Rule
{
    /**
     * @var array<int, string>
     */
    public array $adverbs = [
        "abajo",
        "acá",
        "acaso",
        "adelante",
        "adentro",
        "adrede",
        "afuera",
        "ahora",
        "ahí",
        "alrededor",
        "allá",
        "allí",
        "anoche",
        "anteayer",
        "antes",
        "apenas",
        "aquí",
        "arriba",
        "así",
        "atrás",
        "aun",
        "aunque",
        "ayer",
        "bastante",
        "bien",
        "casi",
        "cerca",
        "ciertamente",
        "como",
        "conmigo",
        "consigo",
        "contra",
        "cuándo",
        "cuánto",
        "debajo",
        "delante",
        "dentro",
        "deprisa",
        "despacio",
        "después",
        "detrás",
        "donde",
        "durante",
        "encima",
        "enfrente",
        "enseguida",
        "entonces",
        "entre",
        "enhorabuena",
        "jamás",
        "lejos",
        "luego",
        "mal",
        "más",
        "mañana",
        "menos",
        "mientras",
        "mucho",
        "muy",
        "nada",
        "no",
        "nunca",
        "ojalá",
        "poco",
        "pronto",
        "quizá",
        "quizás",
        "sí",
        "siempre",
        "sólo",
        "solamente",
        "suficiente",
        "también",
        "tampoco",
        "tarde",
        "temprano",
        "todavía",
        "todo",
        "ya",
    ];



    public function __invoke(string $word, Language $language): Collection
    {
        /** @var Collection<int, string> $variants */
        $variants = collect();

        if (in_array($word, $this->adverbs)) {
            $variants->push($word);
            return $variants;
        }

        $last = mb_substr($word, -1);
        if ('o' === $last) {
            $word = mb_substr($word, 0, -1) . 'a';
        } elseif ('a' !== $last && 'e' !== $last) {
            $word .= 'a';
        }

        $variants->push($word . 'mente');

        /** @var Collection<int, string> $variants */
        return $variants;
    }


    public function name(): string
    {
        return 'adverb';
    }
}
