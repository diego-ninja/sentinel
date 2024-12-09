<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class RepeatedCharStrategy implements DetectionStrategy
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
                        $matches->add(new Coincidence($match, MatchType::Repeated));
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
}
