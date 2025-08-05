<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Detection\OptimizedLevenshtein;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class LevenshteinStrategy extends AbstractStrategy
{
    public const float STRATEGY_EFFICIENCY = 4.0;

    private int $threshold;

    public function __construct(protected LanguageCollection $languages)
    {
        /** @var int $threshold */
        $threshold = config('sentinel.services.local.levenshtein_threshold', 1);
        $this->threshold = $threshold;

        parent::__construct($this->languages);
    }

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        $dictionary = iterator_to_array($language->words());
        $levenshtein = new OptimizedLevenshtein($dictionary);

        // Usamos preg_match_all para obtener palabras y sus posiciones originales
        preg_match_all('/[\p{L}\p{N}]+/u', $text, $textWords, PREG_OFFSET_CAPTURE);
        if (empty($textWords[0])) {
            return $matches;
        }

        foreach ($textWords[0] as [$textWord, $offset]) {
            // Comparamos la palabra limpia con el diccionario
            $similarWords = $levenshtein->findSimilar($textWord, $this->threshold);
            if ( ! empty($similarWords)) {
                $occurrences = new OccurrenceCollection([
                    new Position($offset, mb_strlen($textWord)),
                ]);

                $matches->addCoincidence(
                    new Coincidence(
                        word: $textWord,
                        type: MatchType::Levenshtein,
                        score: Calculator::score($text, $textWord, MatchType::Levenshtein, $occurrences, $language),
                        confidence: Calculator::confidence($text, $textWord, MatchType::Levenshtein, $occurrences),
                        occurrences: $occurrences,
                        language: $language->code(),
                        context: ['similar_words' => $similarWords],
                    ),
                );
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Levenshtein->weight();
    }
}
