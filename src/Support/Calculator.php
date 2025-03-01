<?php

namespace Ninja\Sentinel\Support;

use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Context\ContextLoader;
use Ninja\Sentinel\Context\ContextModifier;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\ValueObject\Confidence;
use Ninja\Sentinel\ValueObject\Position;
use Ninja\Sentinel\ValueObject\Score;

final readonly class Calculator
{
    /**
     * Base multiplier for occurrence boost
     */
    private const float OCCURRENCE_MULTIPLIER = 0.2;

    /**
     * Maximum boost that can be applied for multiple occurrences
     */
    private const float MAX_OCCURRENCE_BOOST = 1.0;

    /**
     * Threshold for short texts that don't need normalization
     */
    private const int SHORT_TEXT_THRESHOLD = 50;

    /**
     * Factor applied to logarithmic normalization to control sensitivity
     */
    private const float NORMALIZATION_FACTOR = 15.0;

    /**
     * Controls how much context affects the final score
     */
    private const float CONTEXT_WEIGHT = 0.7;

    /**
     * Calculate the score for a match based on text characteristics, match type and context
     *
     * @param string $text The full text being analyzed
     * @param string $word The matched word or phrase
     * @param MatchType $type The type of match detected
     * @param OccurrenceCollection $occurrences Collection of match occurrences
     * @param string|null $language Language code or null for auto-detection
     * @return Score The calculated score
     */
    public static function score(
        string $text,
        string $word,
        MatchType $type,
        OccurrenceCollection $occurrences,
        ?string $language = null,
    ): Score {
        $words = explode(' ', $word);
        $total = count(explode(' ', $text));

        $typeWeight = match ($type) {
            MatchType::Exact => 2.0,
            MatchType::Trie => 1.8,
            MatchType::Pattern => 1.5,
            MatchType::NGram => 1.3,
            default => $type->weight(),
        };

        $lengthMultiplier = count($words) > 1 ? 1.5 : 1.2;
        $densityMultiplier = min(2.0, 1 + $occurrences->density($total));
        $occurrenceBoost = min(
            self::MAX_OCCURRENCE_BOOST,
            ($occurrences->count() - 1) * self::OCCURRENCE_MULTIPLIER,
        );

        // Apply normalization for text length
        $normalizedTotal = self::normalizeTextLength($total);

        $baseScore = ($typeWeight * $lengthMultiplier * count($words)) / max($normalizedTotal, 1);
        $boostedScore = $baseScore * (1 + $occurrenceBoost);

        // Apply context analysis and adjust score
        $contextModifier = self::analyzeContext($text, $occurrences, $language);
        $contextAdjustedScore = $boostedScore * (1 + (($contextModifier - 1) * self::CONTEXT_WEIGHT));

        return new Score(min(1.0, $contextAdjustedScore * $densityMultiplier));
    }

    /**
     * Calculate the confidence for a match
     *
     * @param string $text The full text being analyzed
     * @param string $word The matched word or phrase
     * @param MatchType $type The type of match detected
     * @param OccurrenceCollection $occurrences Collection of match occurrences
     * @return Confidence The calculated confidence
     */
    public static function confidence(string $text, string $word, MatchType $type, OccurrenceCollection $occurrences): Confidence
    {
        // If no occurrences, return minimum confidence
        if ($occurrences->isEmpty()) {
            return new Confidence(0.3); // Minimum baseline confidence
        }

        // Base confidence from a match type
        $baseConfidence = $type->weight();

        // Boost based on number of occurrences (diminishing returns)
        $occurrenceBoost = min(0.3, ($occurrences->count() - 1) * 0.1);

        // Density factor - how much of the text is occupied by this offensive word
        $textLength = mb_strlen($text);
        $densityFactor = 0.0;

        if ($textLength > 0) {
            /** @var int $totalMatchLength */
            $totalMatchLength = $occurrences->sum(fn(Position $pos) => $pos->length());
            $densityFactor = $totalMatchLength / $textLength;
            $densityBoost = min(0.15, $densityFactor * 2.0); // Max 0.15 boost
        } else {
            $densityBoost = 0.0;
        }

        // Lexical similarity factor for approximate matches
        $similarityBoost = 0.0;
        if (MatchType::Levenshtein === $type) {
            // For Levenshtein, lower confidence if more changes were needed
            $levenshteinDistance = levenshtein(
                mb_strtolower($word),
                mb_strtolower(mb_substr($text, $occurrences->first()->start(), $occurrences->first()->length())),
            );
            // Negative boost based on distance
            $similarityBoost = max(-0.2, -0.05 * $levenshteinDistance);
        }

        // Total confidence score
        $totalConfidence = $baseConfidence + $occurrenceBoost + $densityBoost + $similarityBoost;

        return new Confidence(min(1.0, max(0.1, $totalConfidence)));
    }

    /**
     * Normalizes text length to prevent excessive score dilution in long texts
     *
     * For short texts (under SHORT_TEXT_THRESHOLD words), keeps the original count.
     * For longer texts, applies logarithmic scaling to prevent excessive dilution.
     *
     * @param int $totalWords Total word count in the text
     * @return float Normalized word count value for score calculation
     */
    private static function normalizeTextLength(int $totalWords): float
    {
        if ($totalWords <= self::SHORT_TEXT_THRESHOLD) {
            return $totalWords; // Original behavior for short texts
        }

        // Logarithmic scaling for longer texts
        return self::SHORT_TEXT_THRESHOLD +
            (log10(max(1, $totalWords - self::SHORT_TEXT_THRESHOLD)) * self::NORMALIZATION_FACTOR);
    }

    /**
     * Analyzes context around occurrences to adjust score based on surrounding content
     *
     * @param string $text The full text being analyzed
     * @param OccurrenceCollection $occurrences Collection of match occurrences
     * @param string|null $language Language code or null for auto-detection
     * @return float Context modifier (>1 increases score, <1 decreases score)
     */
    private static function analyzeContext(
        string $text,
        OccurrenceCollection $occurrences,
        ?string $language = null,
    ): float {
        if ($occurrences->isEmpty()) {
            return 1.0;
        }

        // Try to determine language from config if not specified
        if (null === $language) {
            /** @var array<string> $configLanguages */
            $configLanguages = config('sentinel.languages', ['en']);
            $language = $configLanguages[0] ?? 'en';

            // Check if the language has context support
            if ( ! ContextLoader::hasContextSupport($language)) {
                $language = 'en'; // Default to English if no context support
            }
        }

        $totalContextModifier = 0.0;

        // Analyze context for each occurrence
        foreach ($occurrences as $position) {
            $contextModifier = ContextModifier::getContextModifier(
                $text,
                $position->start(),
                $position->length(),
                $language,
            );

            $totalContextModifier += $contextModifier;
        }

        // Average the context modifiers
        return $totalContextModifier / $occurrences->count();
    }
}
