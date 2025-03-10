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

/**
 * Strategy for detecting potentially offensive terms in safe/legitimate contexts
 * to reduce false positives by assigning negative scores to these matches.
 */
final class SafeContextStrategy extends AbstractStrategy
{
    public const float STRATEGY_EFFICIENCY = 1.5;

    /**
     * Negative score value for safe language matches
     */
    private const float SAFE_CONTEXT_SCORE = -0.4;

    /**
     * Confidence value for safe language detection
     */
    private const float SAFE_CONTEXT_CONFIDENCE = 0.85;


    /**
     * Detect potentially offensive terms in safe contexts
     *
     * @param string $text Text to analyze
     * @param Language|null $language |null Language for text
     * @return MatchCollection Collection of matches in safe contexts
     */
    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }
        $textWords = preg_split('/\s+/', $text);

        if (empty($textWords)) {
            return $matches;
        }

        foreach ($textWords as $position => $textWord) {
            $cleanWord = preg_replace('/[^\p{L}\p{N}]+/u', '', $textWord);
            if (empty($cleanWord)) {
                continue;
            }

            $cleanWord = mb_strtolower($cleanWord);

            if (mb_strlen($cleanWord) < 3) {
                continue;
            }

            // Check if this is a potentially offensive word
            foreach ($language->words() as $offensiveWord) {
                $offensiveWord = mb_strtolower($offensiveWord);

                if ($cleanWord === $offensiveWord || false !== mb_strpos($cleanWord, $offensiveWord)) {
                    // Check all language detectors
                    foreach ($language->contexts() as $context) {
                        /** @var Context $context */
                        if ($context->isSafe($text, $cleanWord, $position, $textWords)) {
                            $startPos = mb_strpos($text, $textWord);

                            if (false !== $startPos) {
                                $occurrences = new OccurrenceCollection([
                                    new Position($startPos, mb_strlen($textWord)),
                                ]);

                                // Add as a match with safe language flag and negative score to counteract
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

                                // Once we find a language match, no need to check other detectors
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $matches;
    }

    /**
     * Returns the weight of this strategy
     *
     * @return float Strategy weight
     */
    public function weight(): float
    {
        // This strategy has high weight since it can override other strategies
        return 0.9;
    }
}
