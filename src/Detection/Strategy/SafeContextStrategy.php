<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Context\ContextDetectorFactory;
use Ninja\Sentinel\Enums\MatchType;
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
    /**
     * Negative score value for safe context matches
     */
    private const float SAFE_CONTEXT_SCORE = -0.4;

    /**
     * Confidence value for safe context detection
     */
    private const float SAFE_CONTEXT_CONFIDENCE = 0.85;
    /**
     * Factory for context detectors
     *
     * @var ContextDetectorFactory
     */
    private ContextDetectorFactory $detectorFactory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detectorFactory = new ContextDetectorFactory();
    }

    /**
     * Detect potentially offensive terms in safe contexts
     *
     * @param string $text Text to analyze
     * @param iterable<string> $words Dictionary of offensive words
     * @return MatchCollection Collection of matches in safe contexts
     */
    public function detect(string $text, iterable $words): MatchCollection
    {
        $matches = new MatchCollection();
        $textWords = preg_split('/\s+/', $text);

        if (empty($textWords)) {
            return $matches;
        }

        $dictionary = is_array($words) ? $words : iterator_to_array($words);

        /** @var string[] $languages */
        $languages = config('sentinel.languages', ['en']);
        $language = $languages[0] ?? 'en';

        // Get all context detectors
        $contextDetectors = $this->detectorFactory->getDetectors();

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
            foreach ($dictionary as $offensiveWord) {
                $offensiveWord = mb_strtolower($offensiveWord);

                if ($cleanWord === $offensiveWord || false !== mb_strpos($cleanWord, $offensiveWord)) {
                    // Check all context detectors
                    foreach ($contextDetectors as $detector) {
                        if ($detector->isInContext($text, $cleanWord, $position, $textWords, $language)) {
                            $startPos = mb_strpos($text, $textWord);

                            if (false !== $startPos) {
                                $occurrences = new OccurrenceCollection([
                                    new Position($startPos, mb_strlen($textWord)),
                                ]);

                                // Add as a match with safe context flag and negative score to counteract
                                $matches->addCoincidence(
                                    new Coincidence(
                                        word: $textWord,
                                        type: MatchType::SafeContext,
                                        // Negative score to counter other matches
                                        score: new Score(self::SAFE_CONTEXT_SCORE),
                                        confidence: new Confidence(self::SAFE_CONTEXT_CONFIDENCE),
                                        occurrences: $occurrences,
                                        context: [
                                            'safe_context' => true,
                                            'original' => $offensiveWord,
                                            'context_type' => $detector->getContextType(),
                                        ],
                                    ),
                                );

                                // Once we find a context match, no need to check other detectors
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
