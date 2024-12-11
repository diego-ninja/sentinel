<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Support\Calculator;
use Ninja\Censor\Support\TextAnalyzer;
use Ninja\Censor\ValueObject\Coincidence;

final class VariationStrategy extends AbstractStrategy
{
    public function __construct(private readonly bool $fullWords = true) {}

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection;

        foreach ($words as $badWord) {
            $chars = preg_split('//u', $badWord, -1, PREG_SPLIT_NO_EMPTY);
            if ($chars === false) {
                continue;
            }

            $pattern = '/\b'.implode('[\s\.\-_\/]*', array_map(
                fn ($c) => preg_quote($c, '/'),
                $chars
            )).'\b/iu';

            if (preg_match_all($pattern, $text, $found) !== false) {
                foreach ($found[0] as $match) {
                    $matches->addCoincidence(
                        new Coincidence(
                            word: $match,
                            type: MatchType::Variation,
                            score: Calculator::score($text, $match, MatchType::Variation),
                            confidence: Calculator::confidence($text, $match, MatchType::Variation),
                            context: ['original' => $badWord, 'variation' => $match]
                        )
                    );
                }
            }

            if (! $this->fullWords) {
                foreach (TextAnalyzer::getSeparatorVariations($badWord) as $variation) {
                    if (! str_contains($variation, ' ') &&
                        mb_stripos($text, $variation) !== false) {
                        $matches->addCoincidence(
                            new Coincidence(
                                word: $variation,
                                type: MatchType::Variation,
                                score: Calculator::score($text, $variation, MatchType::Variation),
                                confidence: Calculator::confidence($text, $variation, MatchType::Variation),
                                context: ['original' => $badWord]
                            )
                        );
                    }
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Variation->weight();
    }
}
