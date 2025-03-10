<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
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

        $index = $this->buildIndex($language);

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
     * @param Language $language
     * @return array<string, string>
     */
    private function buildIndex(Language $language): array
    {
        $index = [];
        $dictionary = iterator_to_array($language->words());

        foreach ($dictionary as $word) {
            $variants = $this->getCachedVariants($word, $language);
            foreach ($variants as $variant) {
                $index[mb_strtolower($variant)] = $word;
            }
        }

        return $index;
    }


    /**
     * @return string[]
     */
    private function getCachedVariants(string $word, Language $language): array
    {
        $key = mb_strtolower($word);
        if ( ! isset($this->cache[$key])) {
            $rule = $language->rules()->findByName('affix');
            if (null === $rule) {
                return [];
            }

            /** @var string[] $variants */
            $variants = $rule($word, $language)->toArray();
            $this->cache[$key] = $variants;
        }

        return $this->cache[$key];
    }
}
