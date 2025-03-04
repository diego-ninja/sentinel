<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class ReversedWordsStrategy extends AbstractStrategy
{
    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        $reversedDictionary = [];
        foreach ($language->words() as $word) {
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
                            score: Calculator::score($text, $textWord, MatchType::Variation, $occurrences, $language),
                            confidence: Calculator::confidence($text, $textWord, MatchType::Variation, $occurrences),
                            occurrences: $occurrences,
                            language: $language->code(),
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
