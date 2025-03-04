<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Enums\PhoneticAlgorithm;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class PhoneticStrategy extends AbstractStrategy
{
    /**
     * @var array<string, array<string>>
     */
    private array $phoneticIndex = [];

    /**
     * @param LanguageCollection $languages
     * @param PhoneticAlgorithm $algorithm
     */
    public function __construct(
        protected LanguageCollection $languages,
        private readonly PhoneticAlgorithm $algorithm = PhoneticAlgorithm::Metaphone,
    ) {
        parent::__construct($languages);
    }

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        if (empty($this->phoneticIndex)) {
            $this->buildPhoneticIndex($language->words());
        }

        $textWords = preg_split('/\s+/', $text);
        if ( ! $textWords) {
            return $matches;
        }

        foreach ($textWords as $textWord) {
            $cleanWord = preg_replace('/[^\p{L}\p{N}]+/u', '', $textWord);
            if (null === $cleanWord) {
                continue;
            }

            if (mb_strlen($cleanWord) < 3) {
                continue;
            }

            $phoneticKey = $this->getPhoneticKey($cleanWord);
            if ( ! $phoneticKey || ! isset($this->phoneticIndex[$phoneticKey])) {
                continue;
            }

            foreach ($this->phoneticIndex[$phoneticKey] as $originalWord) {
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
                                'variation_type' => 'phonetic',
                                'algorithm' => $this->algorithm->value,
                                'clean_word' => $cleanWord,
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
        return 0.75;
    }

    /**
     * @param iterable<string> $words
     * @return void
     */
    private function buildPhoneticIndex(iterable $words): void
    {
        foreach ($words as $word) {
            $cleanWord = preg_replace('/[^\p{L}\p{N}]+/u', '', $word);

            if (null === $cleanWord) {
                continue;
            }

            if (mb_strlen($cleanWord) < 3) {
                continue;
            }

            $phoneticKey = $this->getPhoneticKey($cleanWord);
            if ($phoneticKey) {
                $this->phoneticIndex[$phoneticKey][] = $word;
            }
        }
    }

    /**
     * @param string $word
     * @return string
     */
    private function getPhoneticKey(string $word): string
    {
        $word = mb_strtolower($word);

        return match ($this->algorithm) {
            PhoneticAlgorithm::Soundex => soundex($word),
            PhoneticAlgorithm::Metaphone => metaphone($word),
        };
    }
}
