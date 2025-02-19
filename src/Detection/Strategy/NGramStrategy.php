<?php

namespace Ninja\Censor\Detection\Strategy;

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Detection\Contracts\DetectionStrategy;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\ValueObject\Coincidence;

final readonly class NGramStrategy implements DetectionStrategy
{
    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();
        $phrases = array_filter((array) $words, fn($word) => str_contains($word, ' '));

        foreach ($phrases as $phrase) {
            $phrasePattern = preg_quote(mb_strtolower($phrase), '/');
            $pattern = '/\b' . $phrasePattern . '\b/iu';

            if (false !== preg_match_all($pattern, mb_strtolower($text), $found, PREG_OFFSET_CAPTURE)) {
                foreach ($found[0] as $match) {
                    $originalText = mb_substr($text, $match[1], mb_strlen($match[0]));
                    $matches->addCoincidence(new Coincidence($originalText, MatchType::NGram));
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::NGram->weight();
    }
}
