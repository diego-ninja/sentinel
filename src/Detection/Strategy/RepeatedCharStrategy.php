<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Detection\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class RepeatedCharStrategy implements DetectionStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();

        $text = mb_convert_encoding($text, 'UTF-8', 'auto');
        foreach ($words as $badWord) {
            $badWord = mb_convert_encoding($badWord, 'UTF-8', 'auto');
            if ( ! $this->hasRepeatedChars($text)) {
                continue;
            }

            $pattern = '/\b';
            foreach (mb_str_split($badWord) as $char) {
                $pattern .= preg_quote($char, '/') . '+';
            }
            $pattern .= '\b/iu';

            if (false !== preg_match_all($pattern, $text, $found)) {
                foreach ($found[0] as $match) {
                    if ($this->hasRepeatedChars($match)) {
                        $matches->addCoincidence(new Coincidence($match, MatchType::Repeated));
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

    private function hasRepeatedChars(string $text): bool
    {
        return (bool) preg_match('/(.)\1+/u', $text);
    }
}
