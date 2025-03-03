<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class RepeatedCharStrategy extends AbstractStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();

        foreach ($words as $badWord) {
            if ( ! $this->hasRepeatedChars($text)) {
                continue;
            }

            $pattern = $this->createPattern($badWord);
            if (false !== preg_match_all($pattern, $text, $found, PREG_OFFSET_CAPTURE)) {
                foreach ($found[0] as [$match, $offset]) {
                    if ($this->hasRepeatedChars($match)) {
                        $occurrences = new OccurrenceCollection([
                            new Position($offset, mb_strlen($match)),
                        ]);

                        $matches->addCoincidence(
                            new Coincidence(
                                word: $match,
                                type: MatchType::Repeated,
                                score: Calculator::score($text, $match, MatchType::Repeated, $occurrences),
                                confidence: Calculator::confidence($text, $match, MatchType::Repeated, $occurrences),
                                occurrences: $occurrences,
                                context: ['original' => $badWord],
                            ),
                        );
                    }
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Repeated->weight();
    }

    private function createPattern(string $word): string
    {
        $pattern = '/\b';
        foreach (mb_str_split($word) as $char) {
            $pattern .= preg_quote($char, '/') . '+';
        }

        return $pattern . '\b/iu';
    }

    private function hasRepeatedChars(string $text): bool
    {
        return (bool) preg_match('/(.)\1+/u', $text);
    }
}
