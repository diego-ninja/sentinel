<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Context;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;

final class SafeContextStrategy extends AbstractStrategy
{
    public const float STRATEGY_EFFICIENCY = 1.5;
    private const float SAFE_CONTEXT_SCORE = -0.4;
    private const float SAFE_CONTEXT_CONFIDENCE = 0.85;

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        preg_match_all('/[\p{L}\p{N}]+/u', $text, $textWords, PREG_OFFSET_CAPTURE);

        if (empty($textWords[0])) {
            return $matches;
        }

        $allWords = array_column($textWords[0], 0);

        foreach ($textWords[0] as $position => [$textWord, $startPos]) {
            $cleanWord = mb_strtolower($textWord);

            if (mb_strlen($cleanWord) < 3) {
                continue;
            }

            foreach ($language->words() as $offensiveWord) {
                $offensiveWordLower = mb_strtolower($offensiveWord);

                if ($cleanWord === $offensiveWordLower || str_contains($cleanWord, $offensiveWordLower)) {
                    foreach ($language->contexts() as $context) {
                        /** @var Context $context */
                        if ($context->isSafe($text, $cleanWord, $offensiveWordLower, $position, $allWords)) {
                            $occurrences = new OccurrenceCollection([
                                new Position($startPos, mb_strlen($textWord)),
                            ]);

                            $matches->addCoincidence(
                                new Coincidence(
                                    word: $textWord,
                                    type: MatchType::SafeContext,
                                    score: new Score(self::SAFE_CONTEXT_SCORE),
                                    confidence: new Confidence(self::SAFE_CONTEXT_CONFIDENCE),
                                    occurrences: $occurrences,
                                    language: $language->code(),
                                    context: [
                                        'safe_context' => true,
                                        'original' => $offensiveWord,
                                        'context_type' => $context->getContextType(),
                                    ],
                                ),
                            );

                            continue 3; // Salta al siguiente $textWord una vez encontrado un contexto seguro
                        }
                    }
                }
            }
        }

        return $matches;
    }

    public function weight(): float
    {
        return 0.9;
    }
}