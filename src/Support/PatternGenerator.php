<?php

namespace Ninja\Censor\Support;

final class PatternGenerator
{
    /**
     * @param  array<string>  $replacements
     */
    public function __construct(private array $replacements = [], private bool $fullWords = false) {}

    /**
     * @return array<string>
     */
    public function forWord(string $word): array
    {
        $basePattern = $this->createBasePattern($word);
        $patterns = [];

        if ($this->fullWords) {
            $patterns[] = '/\b'.$basePattern.'\b/iu';
        } else {
            $patterns[] = '/'.$basePattern.'/iu';
            $patterns[] = '/'.implode('\s+', str_split($basePattern)).'/iu';
            $patterns[] = '/'.implode('[.\-_]+', str_split($basePattern)).'/iu';
        }

        return array_filter($patterns, fn ($pattern) => $this->isValidPattern($pattern));
    }

    /**
     * @param  array<string>  $words
     * @return array<string>
     */
    public function forWords(array $words): array
    {
        $patterns = [];
        foreach ($words as $word) {
            $patterns = array_merge($patterns, $this->forWord($word));
        }

        return array_unique($patterns);
    }

    private function createBasePattern(string $word): string
    {
        $escaped = preg_quote($word, '/');

        if ($this->fullWords) {
            return $escaped;
        }

        return str_ireplace(
            array_map(fn ($key) => preg_quote($key, '/'), array_keys($this->replacements)),
            array_values($this->replacements),
            $escaped
        );
    }

    private function isValidPattern(string $pattern): bool
    {
        return @preg_match($pattern, '') !== false;
    }

    public function setFullWords(bool $fullWords): self
    {
        $this->fullWords = $fullWords;

        return $this;
    }

    /**
     * @param  array<string>  $replacements
     */
    public function setReplacements(array $replacements): self
    {
        $this->replacements = $replacements;

        return $this;
    }
}
