<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\ValueObject\Coincidence;

final class AffixStrategy implements DetectionStrategy
{
    /** @var array<string, array<string>> */
    private array $cache = [];

    /**
     * @param  array<string>  $prefixes
     * @param  array<string>  $suffixes
     */
    public function __construct(private readonly array $prefixes = [], private readonly array $suffixes = []) {}

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection;

        $textWords = array_unique(
            preg_split('/\b|\s+/', $text, -1, PREG_SPLIT_NO_EMPTY)
        );

        $index = $this->buildIndex($words);

        foreach ($textWords as $textWord) {
            /** @var string $textWord */
            $lowerTextWord = mb_strtolower($textWord);
            if (isset($index[$lowerTextWord])) {
                $matches->add(new Coincidence($textWord, MatchType::Variation));
            }
        }

        return $matches;

    }

    /**
     * @param  iterable<string>  $words
     * @return array<string, string>
     */
    private function buildIndex(iterable $words): array
    {
        $index = [];
        $dictionary = is_array($words) ? $words : iterator_to_array($words);

        foreach ($dictionary as $word) {
            $variants = $this->getCachedVariants($word);
            foreach ($variants as $variant) {
                $index[mb_strtolower($variant)] = $word;
            }
        }

        return $index;
    }

    /**
     * @return array<string>
     */
    private function generateVariants(string $word): array
    {
        $variants = [];

        foreach ($this->prefixes as $prefix) {
            $variants[] = $prefix.$word;

            foreach ($this->generateSuffixVariants($word) as $suffixVariant) {
                $variants[] = $prefix.$suffixVariant;
            }
        }

        $variants = array_merge($variants, $this->generateSuffixVariants($word));

        return array_unique($variants);
    }

    /**
     * @return array<string>
     */
    private function generateSuffixVariants(string $word): array
    {
        $variants = [];

        if (preg_match('/[aeiou][bcdfghjklmnpqrstvwxz]$/i', $word)) {
            $doubles = $word.mb_substr($word, -1);
            foreach ($this->suffixes as $suffix) {
                if (in_array($suffix, ['ing', 'ed', 'er', 'est'])) {
                    $variants[] = $doubles.$suffix;
                }
            }
        }

        if (mb_substr($word, -1) === 'e') {
            $base = mb_substr($word, 0, -1);
            foreach ($this->suffixes as $suffix) {
                if (in_array($suffix, ['ing', 'er', 'est'])) {
                    $variants[] = $base.$suffix;
                }
            }
        }

        foreach ($this->suffixes as $suffix) {
            $variants[] = $word.$suffix;
        }

        if (mb_substr($word, -1) === 'y') {
            $base = mb_substr($word, 0, -1);
            $variants[] = $base.'ies';
            $variants[] = $base.'ied';
            $variants[] = $base.'ier';
            $variants[] = $base.'iest';
        }

        return $variants;
    }

    /**
     * @return array<string>
     */
    private function getCachedVariants(string $word): array
    {
        $key = mb_strtolower($word);
        if (! isset($this->cache[$key])) {
            $this->cache[$key] = $this->generateVariants($word);
        }

        return $this->cache[$key];
    }
}
