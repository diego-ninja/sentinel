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
    public const float STRATEGY_EFFICIENCY = 3.5;

    /**
     * @var array<string, array<string>>
     */
    private array $phoneticIndex = [];

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
            if (empty($cleanWord) || mb_strlen($cleanWord) < 3) {
                continue;
            }

            $phoneticKey = $this->getPhoneticKey($cleanWord);
            if (empty($phoneticKey) || ! isset($this->phoneticIndex[$phoneticKey])) {
                continue;
            }

            $originalWordMatch = null;
            foreach ($this->phoneticIndex[$phoneticKey] as $originalWord) {
                // AÑADIDO: Comprobación Levenshtein para mayor precisión.
                // Solo es una coincidencia si suena parecido Y se escribe parecido.
                if (levenshtein(mb_strtolower($cleanWord), mb_strtolower($originalWord)) <= 2) {
                    $originalWordMatch = $originalWord;
                    break;
                }
            }

            if ($originalWordMatch) {
                $positions = [];
                $pos = 0;
                while (($pos = mb_stripos($text, $textWord, $pos)) !== false) {
                    $positions[] = new Position($pos, mb_strlen($textWord));
                    $pos += mb_strlen($textWord);
                }

                if (!empty($positions)) {
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
                                'original' => $originalWordMatch,
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
     */
    private function buildPhoneticIndex(iterable $words): void
    {
        foreach ($words as $word) {
            $cleanWord = preg_replace('/[^\p{L}\p{N}]+/u', '', $word);
            if (!is_string($cleanWord)) {
                continue;
            }

            if (empty($cleanWord) || mb_strlen($cleanWord) < 3) {
                continue;
            }

            $phoneticKey = $this->getPhoneticKey($cleanWord);
            if ($phoneticKey) {
                if (!isset($this->phoneticIndex[$phoneticKey])) {
                    $this->phoneticIndex[$phoneticKey] = [];
                }
                $this->phoneticIndex[$phoneticKey][] = $word;
            }
        }
    }

    private function getPhoneticKey(string $word): string
    {
        $word = mb_strtolower($word);

        return match ($this->algorithm) {
            PhoneticAlgorithm::Soundex => soundex($word),
            PhoneticAlgorithm::Metaphone => metaphone($word),
        };
    }
}