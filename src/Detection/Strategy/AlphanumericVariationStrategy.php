<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class AlphanumericVariationStrategy extends AbstractStrategy
{
    public const float STRATEGY_EFFICIENCY = 2.5;

    public function __construct(
        protected LanguageCollection $languages,
        private readonly int $maxAffixLength = 5,
    ) {
        parent::__construct($languages);
    }

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        $dictionary = iterator_to_array($language->words());

        $basePattern = '/([\d_\-\.]*)?(%s)([\d_\-\.]*)?/iu';

        foreach ($dictionary as $word) {
            if (mb_strlen($word) < 3) {
                continue;
            }

            $escapedWord = preg_quote($word, '/');
            $currentPattern = sprintf($basePattern, $escapedWord);

            if (preg_match_all($currentPattern, $text, $found, PREG_OFFSET_CAPTURE)) {
                foreach ($found[0] as $index => [$match, $offset]) {
                    $prefix = $found[1][$index][0];
                    $suffix = $found[3][$index][0];

                    // Solo procesar si hay alfijos alfanuméricos
                    if ('' === $prefix && '' === $suffix) {
                        continue;
                    }
                    
                    // Verificar que al menos uno de los alfijos contenga números
                    if (!preg_match('/\d/', $prefix . $suffix)) {
                        continue;
                    }

                    $affixLength = mb_strlen($match) - mb_strlen($word);
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
                            score: Calculator::score($text, $match, MatchType::Variation, $occurrences, $language),
                            confidence: Calculator::confidence($text, $match, MatchType::Variation, $occurrences),
                            occurrences: $occurrences,
                            language: $language->code(),
                            context: [
                                'original' => $word,
                                'variation_type' => 'alphanumeric',
                            ],
                        ),
                    );
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Variation->weight() - 0.05;
    }

}
