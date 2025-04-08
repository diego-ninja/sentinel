<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class AlphanumericVariationStrategy extends AbstractStrategy
{
    public function __construct(
        private readonly int $maxAffixLength = 5,
    ) {}

    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();
        $dictionary = is_array($words) ? $words : iterator_to_array($words);

        $prefixPattern = '/(\d*|[_\-\.]+)(%s)/iu';   // Para 123fuck
        $suffixPattern = '/(%s)(\d*|[_\-\.]+)/iu';   // Para fuck123, fuck_88
        $mixedPattern = '/(\d*|[_\-\.]+)(%s)(\d*|[_\-\.]+)/iu';   // Para 123fuck456

        foreach ($dictionary as $word) {
            if (mb_strlen($word) < 3) {
                continue;
            }

            $escapedWord = preg_quote($word, '/');

            $currentPattern = sprintf($prefixPattern, $escapedWord);
            $this->findMatches($text, $currentPattern, $word, $matches);

            $currentPattern = sprintf($suffixPattern, $escapedWord);
            $this->findMatches($text, $currentPattern, $word, $matches);

            $currentPattern = sprintf($mixedPattern, $escapedWord);
            $this->findMatches($text, $currentPattern, $word, $matches);
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Variation->weight() - 0.05;
    }

    /**
     * @param string $text
     * @param string $pattern
     * @param string $baseWord
     * @param MatchCollection $matches
     */
    private function findMatches(
        string $text,
        string $pattern,
        string $baseWord,
        MatchCollection $matches,
    ): void {
        if (preg_match_all($pattern, $text, $found, PREG_OFFSET_CAPTURE)) {
            foreach ($found[0] as [$match, $offset]) {
                $affixLength = mb_strlen($match) - mb_strlen($baseWord);
                if ($affixLength > $this->maxAffixLength) {
                    continue;
                }

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
                        context: [
                            'original' => $baseWord,
                            'variation_type' => 'alphanumeric',
                        ],
                    ),
                );
            }
        }
    }
}
