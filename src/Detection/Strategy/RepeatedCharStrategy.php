<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Support\Calculator;
use Ninja\Censor\ValueObject\Coincidence;

final class RepeatedCharStrategy extends AbstractStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection;

        foreach ($words as $badWord) {
            if (! $this->hasRepeatedChars($text)) {
                continue;
            }

            $pattern = '/\b';
            foreach (str_split($badWord) as $char) {
                $pattern .= preg_quote($char, '/').'+';
            }
            $pattern .= '\b/iu';

            if (preg_match_all($pattern, $text, $found) !== false) {
                foreach ($found[0] as $match) {
                    if ($this->hasRepeatedChars($match)) {
                        $matches->addCoincidence(
                            new Coincidence(
                                word: $match,
                                type: MatchType::Repeated,
                                score: Calculator::score($text, $match, MatchType::Repeated),
                                confidence: Calculator::confidence($text, $match, MatchType::Repeated),
                                context: ['original' => $badWord, 'variation' => $match]
                            )
                        );
                    }
                }
            }
        }

        return $matches;
    }

    private function hasRepeatedChars(string $text): bool
    {
        return (bool) preg_match('/(.)\1+/u', $text);
    }

    public function weight(): float
    {
        return MatchType::Repeated->weight();
    }
}
