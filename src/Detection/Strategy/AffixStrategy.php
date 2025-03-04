<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class AffixStrategy extends AbstractStrategy
{
    /** @var array<string, array<string>> */
    private array $cache = [];

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        $textWords = preg_split('/\b|\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        if ( ! $textWords) {
            return $matches;
        }

        $index = $this->buildIndex($language->words(), $language->code());

        foreach (array_unique($textWords) as $textWord) {
            /** @var string $textWord */
            $lowerTextWord = mb_strtolower($textWord);
            if (isset($index[$lowerTextWord])) {
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
                                'original' => $index[$lowerTextWord],
                                'variation_type' => 'affix',
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
        return MatchType::Variation->weight();
    }

    /**
     * @param  iterable<string>  $words
     * @return array<string, string>
     */
    private function buildIndex(iterable $words, LanguageCode $code): array
    {
        $index = [];
        $dictionary = is_array($words) ? $words : iterator_to_array($words);

        foreach ($dictionary as $word) {
            $variants = $this->getCachedVariants($word, $code);
            foreach ($variants as $variant) {
                $index[mb_strtolower($variant)] = $word;
            }
        }

        return $index;
    }

    /**
     * @return array<string>
     */
    private function generateVariants(string $word, LanguageCode $code): array
    {
        $variants = [];
        $mb_word = mb_strtolower($word);

        $prefixes = $this->languages->findByCode($code)?->prefixes();
        if (null === $prefixes) {
            return $this->generateSuffixVariants($mb_word, $code);
        }

        foreach ($prefixes as $prefix) {
            $variants[] = $prefix . $mb_word;
            foreach ($this->generateSuffixVariants($mb_word, $code) as $suffixVariant) {
                $variants[] = $prefix . $suffixVariant;
            }
        }

        return array_merge($variants, $this->generateSuffixVariants($mb_word, $code));
    }

    /**
     * @return array<string>
     */
    private function generateSuffixVariants(string $word, LanguageCode $code): array
    {
        $variants = [];

        $suffixes = $this->languages->findByCode($code)?->suffixes();
        if (null === $suffixes) {
            return $variants;
        }

        if (preg_match('/[aeiou][bcdfghjklmnpqrstvwxz]$/i', $word)) {
            $doubles = $word . mb_substr($word, -1);
            foreach ($suffixes as $suffix) {
                if (in_array($suffix, ['ing', 'ed', 'er', 'est'])) {
                    $variants[] = $doubles . $suffix;
                }
            }
        }

        if ('e' === mb_substr($word, -1)) {
            $base = mb_substr($word, 0, -1);
            foreach ($suffixes as $suffix) {
                if (in_array($suffix, ['ing', 'er', 'est'])) {
                    $variants[] = $base . $suffix;
                }
            }
        }

        foreach ($suffixes as $suffix) {
            $variants[] = $word . $suffix;
        }

        if ('y' === mb_substr($word, -1)) {
            $base = mb_substr($word, 0, -1);
            $variants[] = $base . 'ies';
            $variants[] = $base . 'ied';
            $variants[] = $base . 'ier';
            $variants[] = $base . 'iest';
        }

        return $variants;
    }

    /**
     * @return array<string>
     */
    private function getCachedVariants(string $word, LanguageCode $code): array
    {
        $key = mb_strtolower($word);
        if ( ! isset($this->cache[$key])) {
            $this->cache[$key] = $this->generateVariants($word, $code);
        }

        return $this->cache[$key];
    }
}
