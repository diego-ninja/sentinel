<?php

namespace Ninja\Censor\Cache;

final class PatternCache
{
    /** @var array<string, string> */
    private array $patterns = [];

    /** @var array<string, int> */
    private array $lastUsed = [];

    public function __construct(
        private readonly int $maxSize = 1000
    ) {}

    public function get(string $key): ?string
    {
        if (isset($this->patterns[$key])) {
            $this->lastUsed[$key] = time();

            return $this->patterns[$key];
        }

        return null;
    }

    public function set(string $key, string $pattern): void
    {
        if (count($this->patterns) >= $this->maxSize) {
            $oldest = array_key_first(
                array_filter(
                    $this->lastUsed,
                    // @phpstan-ignore argument.type
                    fn ($time) => $time === min(array_values($this->lastUsed))
                )
            );
            unset($this->patterns[$oldest], $this->lastUsed[$oldest]);
        }

        $this->patterns[$key] = $pattern;
        $this->lastUsed[$key] = time();
    }
}
