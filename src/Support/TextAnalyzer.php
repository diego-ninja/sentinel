<?php

namespace Ninja\Censor\Support;

final readonly class TextAnalyzer
{
    public static function isSimilar(string $word1, string $word2, int $threshold = 2): bool
    {
        // Convert to lowercase for comparison
        $word1 = mb_strtolower($word1);
        $word2 = mb_strtolower($word2);

        // Length difference check
        $lenDiff = abs(mb_strlen($word1) - mb_strlen($word2));
        if ($lenDiff > $threshold) {
            return false;
        }

        // Minimum length check (words shorter than 4 chars need exact match)
        if (mb_strlen($word1) < 4 || mb_strlen($word2) < 4) {
            return $word1 === $word2;
        }

        // Length similarity ratio check
        $maxLen = max(mb_strlen($word1), mb_strlen($word2));
        $minLen = min(mb_strlen($word1), mb_strlen($word2));
        $lengthRatio = $minLen / $maxLen;

        if ($lengthRatio < 0.75) {  // Words should be at least 75% similar in length
            return false;
        }

        // First character match for short words
        if ($maxLen <= 5 && $word1[0] !== $word2[0]) {
            return false;
        }

        // Common prefix/suffix check for better accuracy
        $minPrefixLength = min(3, mb_strlen($word1), mb_strlen($word2));
        if (mb_substr($word1, 0, $minPrefixLength) !== mb_substr($word2, 0, $minPrefixLength)) {
            return false;
        }

        // Calculate Levenshtein distance
        $distance = levenshtein($word1, $word2);

        // For longer words, allow slightly more variance
        $adjustedThreshold = $maxLen > 8 ? $threshold + 1 : $threshold;

        return $distance <= $adjustedThreshold;
    }

    public static function normalizeRepeatedChars(string $word): ?string
    {
        return preg_replace('/(.)\1+/', '$1', $word);
    }

    /**
     * @return array<string>
     */
    public static function getSeparatorVariations(string $word): array
    {
        $letters = mb_str_split($word);

        return [
            $word, // Original word
            implode(' ', $letters), // Spaced
            implode('.', $letters), // Dotted
            implode('-', $letters), // Hyphenated
            implode('_', $letters), // Underscored
            implode('/', $letters), // Slashed
        ];
    }

    /**
     * @return array<string>
     */
    public static function getNGrams(string $text, int $n = 2): array
    {
        $words = preg_split('/\s+/', trim(mb_strtolower($text)));
        $ngrams = [];

        if ($words === false) {
            return $ngrams;
        }

        if (count($words) < $n) {
            return $ngrams;
        }

        for ($i = 0; $i <= count($words) - $n; $i++) {
            $ngrams[] = implode(' ', array_slice($words, $i, $n));
        }

        return $ngrams;
    }

    /**
     * Calculate toxicity score based on matches and various factors
     *
     * @param  array<int, array{word: string, type: string}>  $matches
     */
    public static function calculateScore(array $matches, string $text): float
    {
        // If no matches, score is 0
        if (count($matches) === 0) {
            return 0.0;
        }

        // Weights for different match types
        $typeWeights = [
            'exact' => 1.0,    // Exact matches are highest confidence
            'ngram' => 0.95,   // Phrases are almost as confident as exact matches
            'variation' => 0.9, // Variations are highly likely to be intentional
            'levenshtein' => 0.8, // Levenshtein matches might be typos/variations
            'unknown' => 0.7,
        ];

        // Calculate text statistics
        $totalWords = count(explode(' ', $text));
        $offensiveWords = 0;
        $weightedScore = 0.0;
        $coveredWords = [];

        foreach ($matches as $match) {
            $matchWords = explode(' ', $match['word']);
            $wordCount = count($matchWords);

            // Avoid counting overlapping matches
            $newWords = array_diff($matchWords, $coveredWords);
            if (count($newWords) === 0) {
                continue;
            }

            // Add newly matched words to covered set
            $coveredWords = array_merge($coveredWords, $matchWords);

            // Weight calculation
            $typeWeight = $typeWeights[$match['type']] ?? $typeWeights['unknown'];

            // Multi-word matches get a bonus
            $lengthMultiplier = $wordCount > 1 ? 1.2 : 1.0;

            // Calculate contribution of this match
            $matchScore = $typeWeight * $lengthMultiplier * $wordCount;
            $weightedScore += $matchScore;
            $offensiveWords += $wordCount;
        }

        // If after filtering overlaps we have no valid matches, score is 0
        if ($offensiveWords === 0) {
            return 0.0;
        }

        // Base score is weighted by the proportion of offensive content
        $baseScore = $weightedScore / max($totalWords, 1);

        // Apply severity multiplier based on offensive content density
        $densityMultiplier = min(1.5, 1 + ($offensiveWords / max($totalWords, 1)));

        return min(1.0, $baseScore * $densityMultiplier);
    }
}
