<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class ZeroWidthStrategy extends AbstractStrategy
{
    /**
     * @var array<string>
     */
    private array $zeroWidthChars = [
        "\u{200B}", // Zero width space
        "\u{200C}", // Zero width non-joiner
        "\u{200D}", // Zero width joiner
        "\u{2060}", // Word joiner
        "\u{FEFF}", // Zero width no-break space
    ];

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();
        $dictionary = is_array($words) ? $words : iterator_to_array($words);

        $cleanText = str_replace($this->zeroWidthChars, '', $text);

        if ($cleanText === $text) {
            return $matches;
        }

        $words = preg_split('/\s+/', $cleanText);
        if ( ! $words) {
            return $matches;
        }

        foreach ($words as $word) {
            $lowercaseWord = mb_strtolower($word);

            foreach ($dictionary as $badWord) {
                if (mb_strtolower($badWord) === $lowercaseWord) {
                    $originalWord = $this->findOriginalWithZeroWidth($text, $word);
                    if ( ! $originalWord) {
                        continue;
                    }

                    $positions = [];
                    $pos = 0;

                    while (($pos = mb_stripos($text, $originalWord, $pos)) !== false) {
                        $positions[] = new Position($pos, mb_strlen($originalWord));
                        $pos += mb_strlen($originalWord);
                    }

                    if ( ! empty($positions)) {
                        $occurrences = new OccurrenceCollection($positions);

                        $matches->addCoincidence(
                            new Coincidence(
                                word: $originalWord,
                                type: MatchType::Variation,
                                score: Calculator::score($text, $originalWord, MatchType::Variation, $occurrences),
                                confidence: Calculator::confidence($text, $originalWord, MatchType::Variation, $occurrences),
                                occurrences: $occurrences,
                                context: [
                                    'original' => $badWord,
                                    'variation_type' => 'zero_width',
                                    'clean_word' => $word,
                                ],
                            ),
                        );
                    }
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return 0.9;
    }

    private function findOriginalWithZeroWidth(string $text, string $cleanWord): ?string
    {
        $pattern = '';

        for ($i = 0; $i < mb_strlen($cleanWord); $i++) {
            $char = mb_substr($cleanWord, $i, 1);
            $pattern .= preg_quote($char, '/');

            if ($i < mb_strlen($cleanWord) - 1) {
                $pattern .= '[\\x{200B}\\x{200C}\\x{200D}\\x{2060}\\x{FEFF}]*';
            }
        }

        if (preg_match('/' . $pattern . '/u', $text, $matches, PREG_OFFSET_CAPTURE)) {
            return $matches[0][0];
        }

        return null;
    }
}
