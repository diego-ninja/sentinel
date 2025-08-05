<?php

namespace Ninja\Sentinel\Detection\Strategy;

use Ninja\Sentinel\Cache\Contracts\PatternCache;
use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\Support\PatternGenerator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

final class PatternStrategy extends AbstractStrategy
{
    public const float STRATEGY_EFFICIENCY = 3.0;

    /**
     * Maximum patterns to process in a single run
     */
    private const int MAX_PATTERNS = 100;

    /**
     * Maximum length of a text to apply all patterns to
     */
    private const int FULL_PATTERN_THRESHOLD = 1000;

    /**
     * Compiled batch patterns for common cases
     * @var array<string,string>
     */
    private array $compiledPatterns = [];

    /**
     * Patterns organized by priority
     * @var array<string,array<string>>
     */
    private array $prioritizedPatterns = [];

    /**
     * @var bool
     */
    private bool $patternsInitialized = false;

    public function __construct(
        protected LanguageCollection        $languages,
        protected readonly PatternGenerator $generator,
        protected readonly PatternCache     $cache,
    ) {
        parent::__construct($this->languages);
        $this->initializePatterns();
    }

    public function detect(string $text, ?Language $language = null): MatchCollection
    {
        $language ??= $this->languages->bestFor($text);
        $matches = new MatchCollection();

        if (null === $language) {
            return $matches;
        }

        // For very large texts, only use essential patterns
        $textLength = mb_strlen($text);
        $patternGroups = ['high'];

        if ($textLength < self::FULL_PATTERN_THRESHOLD) {
            $patternGroups[] = 'medium';

            // Only use low priority patterns for small texts
            if ($textLength < 200) {
                $patternGroups[] = 'low';
            }
        }

        // First try batch patterns for performance
        $this->applyBatchPatterns($text, $matches, $language);

        // If batch patterns found something, we can be more selective
        $threshold = $matches->isEmpty() ? 0 : 0.7;

        // Apply individual patterns by priority
        foreach ($patternGroups as $priority) {
            // Skip lower priorities if we've already found strong matches
            if ( ! $matches->isEmpty() && $matches->confidence()->value() > $threshold) {
                break;
            }

            $this->applyPriorityPatterns($text, $priority, $matches, $language);
        }

        return $matches;
    }

    public function weight(): float
    {
        return MatchType::Pattern->weight();
    }

    /**
     * Loads and organizes patterns with optimized batching
     */
    private function initializePatterns(): void
    {
        if ($this->patternsInitialized) {
            return;
        }

        // Get patterns from generator or cache
        $patterns = $this->loadCachedPatterns();

        // Build prioritized pattern groups
        $this->prioritizedPatterns = [
            'high' => [],
            'medium' => [],
            'low' => [],
        ];

        // Prioritize patterns
        foreach ($patterns as $i => $pattern) {
            // Skip invalid patterns
            if ( ! $this->isValidPattern($pattern)) {
                continue;
            }

            // Determine pattern priority based on complexity and specificity
            if (str_contains($pattern, '\b')   && mb_strlen($pattern) < 100) {
                $this->prioritizedPatterns['high'][] = $pattern;
            } elseif (mb_strlen($pattern) < 150) {
                $this->prioritizedPatterns['medium'][] = $pattern;
            } else {
                $this->prioritizedPatterns['low'][] = $pattern;
            }

            // Cap each priority group
            foreach (['high', 'medium', 'low'] as $priority) {
                if (count($this->prioritizedPatterns[$priority]) > self::MAX_PATTERNS) {
                    $this->prioritizedPatterns[$priority] = array_slice(
                        $this->prioritizedPatterns[$priority],
                        0,
                        self::MAX_PATTERNS,
                    );
                }
            }
        }

        // Create combined patterns for performance
        $this->compileBatchPatterns();

        $this->patternsInitialized = true;
    }

    /**
     * Compiles batch patterns from individual patterns
     */
    private function compileBatchPatterns(): void
    {
        // Combine word boundary patterns
        if ( ! empty($this->prioritizedPatterns['high'])) {
            $wordPatterns = [];
            foreach ($this->prioritizedPatterns['high'] as $pattern) {
                if (preg_match('/\\\\b(.*?)\\\\b/i', $pattern, $matches)) {
                    $wordPatterns[] = $matches[1];
                }
            }

            if ( ! empty($wordPatterns)) {
                // Construct a batch pattern with alternation
                $this->compiledPatterns['words'] = '/\\b(?:' . implode('|', $wordPatterns) . ')\\b/ui';
            }
        }
    }

    /**
     * Loads patterns from cache or generator
     * @return array<string>
     */
    private function loadCachedPatterns(): array
    {
        $cacheKey = 'sentinel_patterns_' . md5((string) time());
        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData) {
            /** @var array<string> $words */
            $words = json_decode($cachedData, true) ?? [];
            return $words;
        }

        // If not cached, load from generator
        return $this->generator->getPatterns();
    }

    /**
     * Validates a pattern is safe to use
     */
    private function isValidPattern(string $pattern): bool
    {
        return false !== @preg_match($pattern, '');
    }

    /**
     * Applies compiled batch patterns for performance
     */
    private function applyBatchPatterns(
        string $text,
        MatchCollection $matches,
        Language $language,
    ): void {
        foreach ($this->compiledPatterns as $type => $pattern) {
            $found = [];
            if (preg_match_all($pattern, $text, $found, PREG_OFFSET_CAPTURE) > 0) {
                foreach ($found[0] as [$match, $offset]) {
                    $occurrences = new OccurrenceCollection([
                        new Position($offset, mb_strlen($match)),
                    ]);

                    $matches->addCoincidence(
                        new Coincidence(
                            word: $match,
                            type: MatchType::Pattern,
                            score: Calculator::score($text, $match, MatchType::Pattern, $occurrences, $language),
                            confidence: Calculator::confidence($text, $match, MatchType::Pattern, $occurrences),
                            occurrences: $occurrences,
                            language: $language->code(),
                            context: ['pattern_type' => $type],
                        ),
                    );
                }
            }
        }
    }

    /**
     * Applies patterns of a specific priority group
     */
    private function applyPriorityPatterns(
        string $text,
        string $priority,
        MatchCollection $matches,
        Language $language,
    ): void {
        foreach ($this->prioritizedPatterns[$priority] as $pattern) {
            $found = [];
            if (preg_match_all($pattern, $text, $found, PREG_OFFSET_CAPTURE) > 0) {
                foreach ($found[0] as [$match, $offset]) {
                    if (mb_strlen($match) < 2) {
                        continue;
                    }

                    $occurrences = new OccurrenceCollection([
                        new Position($offset, mb_strlen($match)),
                    ]);

                    $matches->addCoincidence(
                        new Coincidence(
                            word: $match,
                            type: MatchType::Pattern,
                            score: Calculator::score($text, $match, MatchType::Pattern, $occurrences, $language),
                            confidence: Calculator::confidence($text, $match, MatchType::Pattern, $occurrences),
                            occurrences: $occurrences,
                            language: $language->code(),
                            context: ['pattern' => $pattern, 'priority' => $priority],
                        ),
                    );
                }
            }
        }
    }
}
