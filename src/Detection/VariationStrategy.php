<?php

namespace Ninja\Censor\Detection;

use Ninja\Censor\Contracts\DetectionStrategy;
use Ninja\Censor\Support\TextAnalyzer;

final readonly class VariationStrategy implements DetectionStrategy
{
    public function __construct(private string $replacer, private bool $fullWords = false) {}

    public function detect(string $text, array $words): array
    {
        $matches = [];
        $clean = $text;

        foreach ($words as $badWord) {
            $spacedPattern = implode('\s*', str_split(preg_quote($badWord, '/')));
            $pattern = $this->fullWords ? '/\b'.$spacedPattern.'\b/iu' : '/'.$spacedPattern.'/iu';

            if (preg_match_all($pattern, $text, $found) !== false) {
                foreach ($found[0] as $match) {
                    $matches[] = ['word' => $match, 'type' => 'variation'];
                    $clean = str_replace(
                        $match,
                        str_repeat($this->replacer, mb_strlen($match)),
                        $clean
                    );
                }
            }

            if (! $this->fullWords) {
                foreach (TextAnalyzer::getSeparatorVariations($badWord) as $variation) {
                    if (! str_contains($variation, ' ') &&
                        mb_stripos($clean, $variation) !== false) {
                        $matches[] = ['word' => $variation, 'type' => 'variation'];
                        $clean = str_replace(
                            $variation,
                            str_repeat($this->replacer, mb_strlen($variation)),
                            $clean
                        );
                    }
                }
            }
        }

        return [
            'clean' => $clean,
            'matches' => $matches,
        ];
    }
}
