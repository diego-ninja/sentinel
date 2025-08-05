<?php

namespace Ninja\Sentinel\Support;

use Ninja\Sentinel\Dictionary\LazyDictionary;

final class PatternGenerator
{
    /**
     * @var array<int|string, string>
     */
    private array $patterns = [];

    /**
     * @param array<string, string> $replacements
     */
    public function __construct(private readonly array $replacements = [], private readonly bool $fullWords = true) {}

    public static function withDictionary(LazyDictionary $dictionary): self
    {
        /** @var array<string, string> $replacements */
        $replacements = config('sentinel.replacements', []);
        $generator = new self($replacements);

        foreach ($dictionary as $word) {
            if (mb_strlen($word) < 3) {
                continue;
            }
            $pattern = $generator->generatePatternForWord($word);
            if ($pattern) {
                $generator->patterns[] = $pattern;
            }
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

    private function generatePatternForWord(string $word): ?string
    {
        if (empty($word)) {
            return null;
        }

        $basePattern = $this->createBasePattern($word);

        // Usamos límites de palabra que respetan Unicode para TODOS los patrones.
        // (?<!\p{L}) = No precedido por una letra Unicode.
        // (?!\p{L})  = No seguido por una letra Unicode.
        $pattern = '/(?<!\p{L})' . $basePattern . '(?!\p{L})/ui';

        if ($this->isValidPattern($pattern)) {
            return $pattern;
        }

        return null;
    }

    private function createBasePattern(string $word): string
    {
        $escaped = preg_quote($word, '/');

        if (! $this->fullWords) {
            return $escaped;
        }

        return str_ireplace(
            array_keys($this->replacements),
            array_values($this->replacements),
            $escaped
        );
    }

    private function isValidPattern(string $pattern): bool
    {
        return @preg_match($pattern, '') !== false;
    }
}