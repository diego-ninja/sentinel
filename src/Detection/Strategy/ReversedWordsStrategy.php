<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class ReversedWordsStrategy extends AbstractStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();
        $dictionary = is_array($words) ? $words : iterator_to_array($words);

        $reversedDictionary = [];
        foreach ($dictionary as $word) {
            if (mb_strlen($word) >= 3) {
                $reversedDictionary[mb_strtolower($this->mbStrRev($word))] = $word;
            }
        }

        if (empty($reversedDictionary)) {
            return $matches;
        }

        $textWords = preg_split('/\s+/', $text);
        if ( ! $textWords) {
            return $matches;
        }

        foreach ($textWords as $textWord) {
            $lowercaseWord = mb_strtolower($textWord);

            if (isset($reversedDictionary[$lowercaseWord])) {
                $originalWord = $reversedDictionary[$lowercaseWord];

                $positions = [];
                $pos = 0;
                while (($pos = mb_stripos($text, $textWord, $pos)) !== false) {
                    $positions[] = new Position($pos, mb_strlen($textWord));
                    $pos += mb_strlen($textWord);
                }

                if ( ! empty($positions)) {
                    $occurrences = new OccurrenceCollection($positions);

                    $matches->addCoincidence(
                        new Coincidence(
                            word: $textWord,
                            type: MatchType::Variation,
                            score: Calculator::score($text, $textWord, MatchType::Variation, $occurrences),
                            confidence: Calculator::confidence($text, $textWord, MatchType::Variation, $occurrences),
                            occurrences: $occurrences,
                            context: [
                                'original' => $originalWord,
                                'variation_type' => 'reversed',
                            ],
                        ),
                    );
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return 0.85;
    }

    private function mbStrRev(string $string): string
    {
        $chars = mb_str_split($string);
        return implode('', array_reverse($chars));
    }
}
