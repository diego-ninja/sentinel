<?php

namespace Ninja\Sentinel\Language\Rules\It;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final class AdverbRule implements Rule
{
    /**
     * @var array<int, string>
     */
    public array $adverbs = [
        "abbastanza",
        "adesso",
        "altrove",
        "anche",
        "ancora",
        "appena",
        "assai",
        "avanti",
        "bene",
        "certo",
        "circa",
        "così",
        "dappertutto",
        "davvero",
        "dopo",
        "domani",
        "dove",
        "già",
        "ieri",
        "indietro",
        "infatti",
        "insieme",
        "intorno",
        "lì",
        "lontano",
        "male",
        "meglio",
        "meno",
        "molto",
        "non",
        "oggi",
        "oltre",
        "perché",
        "più",
        "poco",
        "presto",
        "qua",
        "quindi",
        "qui",
        "sempre",
        "sicuramente",
        "solo",
        "spesso",
        "subito",
        "tanto",
        "tardi",
        "troppo",
        "tuttavia",
        "vicino",
    ];

    public function __invoke(string $word, Language $language): Collection
    {
        /** @var Collection<int, string> $variants */
        $variants = collect();

        if (in_array(mb_strtolower($word), $this->adverbs)) {
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
