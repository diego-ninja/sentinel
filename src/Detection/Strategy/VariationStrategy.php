<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\Support\TextAnalyzer;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class VariationStrategy extends AbstractStrategy
{
    public function __construct(private readonly bool $fullWords = true) {}

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();

        foreach ($words as $word) {
            if ($this->fullWords) {
                $this->detectFullWords($text, $word, $matches);
            } else {
                $this->detectPartialWords($text, $word, $matches);
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Variation->weight();
    }

    private function detectFullWords(string $text, string $word, MatchCollection $matches): void
    {
        $chars = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);
        if (false === $chars) {
            return;
        }

        $pattern = '/\b' . implode('[\s\.\-_\/]*', array_map(
            fn($c) => preg_quote($c, '/'),
            $chars,
        )) . '\b/iu';

        if (false !== preg_match_all($pattern, $text, $found, PREG_OFFSET_CAPTURE)) {
            foreach ($found[0] as [$match, $offset]) {
                $occurrences = new OccurrenceCollection([
                    new Position($offset, mb_strlen($match)),
                ]);

                $matches->addCoincidence(
                    new Coincidence(
                        word: $match,
                        type: MatchType::Variation,
                        score: Calculator::score($text, $match, MatchType::Variation, $occurrences),
                        confidence: Calculator::confidence($text, $match, MatchType::Variation, $occurrences),
                        occurrences: $occurrences,
                        context: ['original' => $word, 'full_word' => true],
                    ),
                );
            }
        }
    }

    private function detectPartialWords(string $text, string $word, MatchCollection $matches): void
    {
        foreach (TextAnalyzer::getSeparatorVariations($word) as $variation) {
            if (str_contains($variation, ' ')) {
                continue;
            }

            $positions = [];
            $pos = 0;
            while (($pos = mb_stripos($text, $variation, $pos)) !== false) {
                $positions[] = new Position($pos, mb_strlen($variation));
                $pos += mb_strlen($variation);
            }

            if ( ! empty($positions)) {
                $occurrences = new OccurrenceCollection($positions);

                $matches->addCoincidence(
                    new Coincidence(
                        word: $variation,
                        type: MatchType::Variation,
                        score: Calculator::score($text, $variation, MatchType::Variation, $occurrences),
                        confidence: Calculator::confidence($text, $variation, MatchType::Variation, $occurrences),
                        occurrences: $occurrences,
                        context: ['original' => $word, 'full_word' => false],
                    ),
                );
            }
        }
    }
}
