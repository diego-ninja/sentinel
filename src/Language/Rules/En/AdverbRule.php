<?php

namespace Ninja\Sentinel\Language\Rules\En;

use Illuminate\Support\Collection;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Language\Contracts\Rule;

final class AdverbRule implements Rule
{
    /**
     * @var array<int, string>
     */
    public array $adverbs = [
        "above",
        "about",
        "abroad",
        "again",
        "ago",
        "ahead",
        "almost",
        "already",
        "also",
        "always",
        "anyway",
        "around",
        "away",
        "back",
        "before",
        "behind",
        "below",
        "besides",
        "better",
        "beyond",
        "both",
        "down",
        "else",
        "even",
        "ever",
        "far",
        "fast",
        "here",
        "how",
        "however",
        "indeed",
        "inside",
        "instead",
        "just",
        "later",
        "less",
        "long",
        "more",
        "most",
        "much",
        "near",
        "never",
        "now",
        "often",
        "once",
        "only",
        "out",
        "outside",
        "rather",
        "really",
        "since",
        "so",
        "soon",
        "still",
        "then",
        "there",
        "therefore",
        "today",
        "together",
        "tomorrow",
        "too",
        "under",
        "up",
        "very",
        "well",
        "when",
        "where",
        "why",
        "yes",
        "yet",
    ];

    public function __invoke(string $word, Language $language): Collection
    {
        /** @var Collection<int, string> $variants */
        $variants = collect();

        if (in_array(mb_strtolower($word), $this->adverbs)) {
            $variants->push($word);
            return $variants;
        }

        // Simplificación: añadir "-ly" como regla general
        $variants->push($word . 'ly');

        /** @var Collection<int, string> $variants */
        return $variants;
    }

    public function name(): string
    {
        return 'adverb';
    }
}
