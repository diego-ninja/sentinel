<?php

namespace Ninja\Censor\Cache;

use Illuminate\Support\Facades\Cache;
use Ninja\Censor\Cache\Contracts\PatternCache;
use Psr\SimpleCache\InvalidArgumentException;

final readonly class RedisPatternCache implements PatternCache
{
    /**
     * @throws InvalidArgumentException
     */
    public function get(string $key): ?string
    {
        /** @var string $pattern */
        $pattern = Cache::store('redis')->get($key);

        return $pattern ?: null;
    }

    public function set(string $key, string $pattern): void
    {
        Cache::store('redis')->put($key, $pattern, now()->addDay());
    }
}
