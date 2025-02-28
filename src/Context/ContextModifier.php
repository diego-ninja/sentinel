<?php

namespace Ninja\Sentinel\Context;

/**
 * Class for analyzing word context to adjust offensive content scores
 * with multilingual support
 */
final class ContextModifier
{
    /**
     * Context window size (words before/after match to analyze)
     */
    private const int CONTEXT_WINDOW = 3;

    /**
     * Analyzes the context around a match and returns a score modifier
     *
     * @param string $text Full text being analyzed
     * @param int $position Start position of the match
     * @param int $length Length of the match
     * @param string|null $language Force specific language ('en', 'es', 'fr') or null for auto-detection
     * @return float Score modifier (>1 increases score, <1 decreases score)
     */
    public static function getContextModifier(string $text, int $position, int $length, ?string $language = null): float
    {
        // Extract text before and after the match
        $beforeText = mb_substr($text, max(0, $position - 100), min(100, $position));
        $afterText = mb_substr($text, $position + $length, min(100, mb_strlen($text) - $position - $length));

        // Clean and split words
        $beforeWords = array_map(
            fn($word) => mb_strtolower(preg_replace('/[^\p{L}\p{N}]+/u', '', $word)),
            array_filter(explode(' ', $beforeText), fn($word) => mb_strlen($word) > 0)
        );

        $afterWords = array_map(
            fn($word) => mb_strtolower(preg_replace('/[^\p{L}\p{N}]+/u', '', $word)),
            array_filter(explode(' ', $afterText), fn($word) => mb_strlen($word) > 0)
        );

        // Take only the closest words within our window
        $beforeWords = array_slice($beforeWords, -self::CONTEXT_WINDOW);
        $afterWords = array_slice($afterWords, 0, self::CONTEXT_WINDOW);

        // Auto-detect language if not specified
        if ($language === null) {
            $language = self::detectLanguage($beforeWords, $afterWords);
        }

        // Ensure we're using a supported language
        if (!ContextLoader::hasContextSupport($language)) {
            $language = 'en'; // Default to English if language not supported
        }

        // Get word categories for the detected language
        $intensifiers = ContextLoader::getCategory($language, 'intensifiers');
        $negativeModifiers = ContextLoader::getCategory($language, 'negative_modifiers');
        $positiveModifiers = ContextLoader::getCategory($language, 'positive_modifiers');
        $educationalContext = ContextLoader::getCategory($language, 'educational_context');
        $pronouns = ContextLoader::getCategory($language, 'pronouns');
        $quoteWords = ContextLoader::getCategory($language, 'quote_words');
        $excuseWords = ContextLoader::getCategory($language, 'excuse_words');

        // Combine nearby words for context analysis
        $contextWords = array_merge($beforeWords, $afterWords);

        // Calculate modifier
        $modifier = 1.0; // Base modifier (no change)

        // Increases for negative context
        foreach ($contextWords as $word) {
            if (in_array($word, $negativeModifiers, true)) {
                $modifier *= 1.3; // Increase score - negative context
            }
        }

        // Check for positive/mitigating context
        foreach ($contextWords as $word) {
            if (in_array($word, $positiveModifiers, true)) {
                $modifier *= 0.7; // Decrease score - positive context
            }
        }

        // Check for intensifiers
        foreach ($contextWords as $word) {
            if (in_array($word, $intensifiers, true)) {
                $modifier *= 1.1; // Slight increase - intensified
            }
        }

        // Check for educational/scientific context
        foreach ($contextWords as $word) {
            if (in_array($word, $educationalContext, true)) {
                $modifier *= 0.5; // Significant decrease - educational context
            }
        }

        // Detect pronoun after offensive word (direct targeting)
        foreach ($afterWords as $word) {
            if (in_array($word, $pronouns, true)) {
                $modifier *= 1.5; // Significant increase - targeted at someone
                break;
            }
        }

        // Common excuses/legitimate phrases
        if (self::detectCommonPhrases($beforeWords, $quoteWords, $excuseWords)) {
            $modifier *= 0.4; // Major decrease for common legitimate phrases
        }

        return $modifier;
    }

    /**
     * Attempts to detect the language of the context
     *
     * @param array<string> $beforeWords Words before the match
     * @param array<string> $afterWords Words after the match
     * @return string Language code ('en', 'es', or 'fr')
     */
    private static function detectLanguage(array $beforeWords, array $afterWords): string
    {
        $contextWords = array_merge($beforeWords, $afterWords);
        if (empty($contextWords)) {
            return 'en'; // Default to English if no context
        }

        // Get supported languages
        $supportedLanguages = ContextLoader::getSupportedLanguages();

        // Count language marker occurrences for each supported language
        $scores = array_fill_keys($supportedLanguages, 0);

        foreach ($supportedLanguages as $lang) {
            try {
                $languageMarkers = ContextLoader::getCategory($lang, 'language_markers');

                foreach ($contextWords as $word) {
                    if (in_array($word, $languageMarkers, true)) {
                        $scores[$lang]++;
                    }
                }
            } catch (\Exception $e) {
                // If we can't load markers, just continue with next language
                continue;
            }
        }

        // Get language with highest score
        arsort($scores);
        $detectedLanguage = key($scores);

        return $detectedLanguage ?: 'en';
    }

    /**
     * Detects common phrases or expressions that may contain offensive words
     * but are used in legitimate contexts
     *
     * @param array<string> $beforeWords Words before the match
     * @param array<string> $quoteWords Quote indicator words
     * @param array<string> $excuseWords Excuse words
     * @return bool True if a common legitimate phrase is detected
     */
    private static function detectCommonPhrases(array $beforeWords, array $quoteWords, array $excuseWords): bool
    {
        // Check for phrases like "excuse my language"
        foreach ($excuseWords as $word) {
            if (in_array($word, $beforeWords, true)) {
                return true;
            }
        }

        // Check for quoted content or reported speech
        foreach ($quoteWords as $word) {
            if (in_array($word, $beforeWords, true)) {
                return true;
            }
        }

        return false;
    }
}