<?php

namespace Ninja\Sentinel\Support;

use Ninja\Sentinel\Dictionary\LazyDictionary;

final class PatternGenerator
{
    /**
     * Maximum pattern length to generate
     */
    private const int MAX_PATTERN_LENGTH = 500;

    /**
     * Maximum number of patterns to generate per tier
     */
    private const int MAX_PATTERNS_PER_TIER = 100;

    /**
     * @var array<int|string, string>
     */
    private array $patterns = [];

    /**
     * @var array<string, array<string, mixed>>
     */
    private array $wordMetadata = [];

    /**
     * @param array<string, string> $replacements
     */
    public function __construct(private readonly array $replacements = [], private readonly bool $fullWords = true) {}

    public static function withDictionary(LazyDictionary $dictionary): self
    {
        /** @var array<string, string> $replacements */
        $replacements = config('sentinel.replacements', []);
        $generator = new self($replacements);

        // Process words in batches for memory efficiency
        $wordBatch = [];
        $batchSize = 200;
        $batchCount = 0;

        foreach ($dictionary as $word) {
            if (mb_strlen($word) < 3 || mb_strlen($word) > 20) {
                continue; // Skip very short/long words
            }

            $wordBatch[] = $word;

            if (count($wordBatch) >= $batchSize) {
                $generator->processWordBatch($wordBatch, $batchCount);
                $wordBatch = [];
                $batchCount++;

                // Generate a reasonable number of patterns
                if (count($generator->patterns) > 1000) {
                    break;
                }
            }
        }

        // Process final batch
        if ( ! empty($wordBatch)) {
            $generator->processWordBatch($wordBatch, $batchCount);
        }

        return $generator;
    }

    /**
     * Get generated patterns
     *
     * @return array<int|string, string>
     */
    public function getPatterns(): array
    {
        return $this->patterns;
    }

    /**
     * Process a batch of words efficiently
     *
     * @param array<string> $words
     * @param int $batchNumber
     */
    private function processWordBatch(array $words, int $batchNumber): void
    {
        // Categorize words by importance and frequency
        $wordTiers = [
            'high' => [],   // Highly offensive
            'medium' => [], // Moderately offensive
            'low' => [],     // Mildly offensive or contextual
        ];

        // Simple word length-based categorization
        foreach ($words as $word) {
            $length = mb_strlen($word);

            if ($length <= 4) {
                $wordTiers['high'][] = $word;
            } elseif ($length <= 8) {
                $wordTiers['medium'][] = $word;
            } else {
                $wordTiers['low'][] = $word;
            }
        }

        // Generate patterns by tier with limits
        foreach ($wordTiers as $tier => $tierWords) {
            if (count($tierWords) > self::MAX_PATTERNS_PER_TIER) {
                $tierWords = array_slice($tierWords, 0, self::MAX_PATTERNS_PER_TIER);
            }

            foreach ($tierWords as $word) {
                // Skip if we already have patterns for similar words
                if ($this->hasSimilarWord($word)) {
                    continue;
                }

                $this->wordMetadata[$word] = [
                    'tier' => $tier,
                    'batch' => $batchNumber,
                ];

                // Generate optimal pattern
                $pattern = $this->generateOptimalPattern($word, $tier);
                if ($pattern) {
                    $this->patterns[] = $pattern;
                }
            }
        }
    }

    /**
     * Check if we already have patterns for similar words
     */
    private function hasSimilarWord(string $word): bool
    {
        // Simple check for now
        return false;
    }

    /**
     * Generate an optimal pattern based on word characteristics
     */
    private function generateOptimalPattern(string $word, string $tier): ?string
    {
        if (empty($word)) {
            return null;
        }

        // For high priority words, use more precise patterns
        if ('high' === $tier) {
            $pattern = '/\b' . $this->createBasePattern($word) . '\b/ui';

            // Verify pattern is valid and not too complex
            if (mb_strlen($pattern) <= self::MAX_PATTERN_LENGTH && $this->isValidPattern($pattern)) {
                return $pattern;
            }
        }

        // For medium words, simpler pattern
        if ('medium' === $tier) {
            $pattern = '/' . $this->createBasePattern($word) . '/ui';

            if (mb_strlen($pattern) <= self::MAX_PATTERN_LENGTH && $this->isValidPattern($pattern)) {
                return $pattern;
            }
        }

        // For low priority, very simple pattern
        return null;
    }

    private function createBasePattern(string $word): string
    {
        $escaped = preg_quote($word, '/');

        if ( ! $this->fullWords) {
            return $escaped;
        }

        // Character substitutions only for high-priority words
        return str_ireplace(
            array_map(fn($key) => preg_quote($key, '/'), array_keys($this->replacements)),
            array_values($this->replacements),
            $escaped,
        );
    }

    private function isValidPattern(string $pattern): bool
    {
        return false !== @preg_match($pattern, '');
    }
}
