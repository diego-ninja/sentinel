<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Support\TextAnalyzer;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class VariationStrategy implements DetectionStrategy
{
    public function __construct(private bool $fullWords = true) {}

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
                    $matches->addCoincidence(new Coincidence($match, MatchType::Variation));
                }
            }

            if (! $this->fullWords) {
                foreach (TextAnalyzer::getSeparatorVariations($badWord) as $variation) {
                    if (! str_contains($variation, ' ') &&
                        mb_stripos($text, $variation) !== false) {
                        $matches->addCoincidence(new Coincidence($variation, MatchType::Variation));
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
