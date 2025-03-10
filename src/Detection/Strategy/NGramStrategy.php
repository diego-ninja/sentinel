<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class NGramStrategy extends AbstractStrategy
{
    public const float STRATEGY_EFFICIENCY = 2.5;

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        $phrases = array_filter(iterator_to_array($language->words()), fn($word) => str_contains($word, ' '));

        foreach ($phrases as $phrase) {
            $phrasePattern = preg_quote(mb_strtolower($phrase), '/');
            $pattern = '/\b' . $phrasePattern . '\b/iu';

            if (false !== preg_match_all($pattern, $text, $found, PREG_OFFSET_CAPTURE)) {
                foreach ($found[0] as [$match, $offset]) {
                    $occurrences = new OccurrenceCollection([
                        new Position($offset, mb_strlen($match)),
                    ]);

                    $matches->addCoincidence(
                        new Coincidence(
                            word: $match,
                            type: MatchType::NGram,
                            score: Calculator::score($text, $match, MatchType::NGram, $occurrences, $language),
                            confidence: Calculator::confidence($text, $match, MatchType::NGram, $occurrences),
                            occurrences: $occurrences,
                            language: $language->code(),
                            context: ['original' => $phrase],
                        ),
                    );
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
