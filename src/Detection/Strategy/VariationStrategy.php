<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Support\TextAnalyzer;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class VariationStrategy implements DetectionStrategy
{
    public function __construct(private bool $fullWords = false) {}

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection;
        $clean = $text;

        foreach ($words as $badWord) {
            $spacedPattern = implode('\s*', str_split(preg_quote($badWord, '/')));
            $pattern = $this->fullWords ? '/\b'.$spacedPattern.'\b/iu' : '/'.$spacedPattern.'/iu';

            if (preg_match_all($pattern, $text, $found) !== false) {
                foreach ($found[0] as $match) {
                    $matches->add(new Coincidence($match, MatchType::Variation));
                }
            }

            if (! $this->fullWords) {
                foreach (TextAnalyzer::getSeparatorVariations($badWord) as $variation) {
                    if (! str_contains($variation, ' ') &&
                        mb_stripos($clean, $variation) !== false) {
                        $matches->add(new Coincidence($variation, MatchType::Variation));
                    }
                }
            }
        }

        return $matches;
    }
}
