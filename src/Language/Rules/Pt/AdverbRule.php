<?php

namespace Ninja\Sentinel\Language\Rules\Pt;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final class AdverbRule implements Rule
{
    /**
     * @var array<int, string>
     */
    public array $adverbs = [
        "abaixo",
        "acima",
        "agora",
        "aí",
        "ali",
        "além",
        "amanhã",
        "antes",
        "aqui",
        "assim",
        "bem",
        "cedo",
        "certamente",
        "como",
        "contudo",
        "depois",
        "devagar",
        "hoje",
        "jamais",
        "lá",
        "logo",
        "mal",
        "mais",
        "menos",
        "muito",
        "nunca",
        "onde",
        "ontem",
        "outrora",
        "pouco",
        "quase",
        "quiçá",
        "sempre",
        "sim",
        "só",
        "tão",
        "tarde",
        "também",
        "tanto",
        "todavia",
        "tudo",
        "vez",
        "já",
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
