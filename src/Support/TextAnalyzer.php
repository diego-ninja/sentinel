<?php

namespace Ninja\Sentinel\Support;

final readonly class TextAnalyzer
{
    /**
     * @return array<string>
     */
    public static function getSeparatorVariations(string $word): array
    {
        $letters = mb_str_split($word);

        return [
            $word, // Original word
            implode(' ', $letters), // Spaced
            implode('.', $letters), // Dotted
            implode('-', $letters), // Hyphenated
            implode('_', $letters), // Underscored
            implode('/', $letters), // Slashed
        ];
    }
}
