<?php

namespace Ninja\Censor\Cache;

use Illuminate\Support\Facades\Cache;
use Ninja\Censor\Cache\Contracts\PatternCache;
use Psr\SimpleCache\InvalidArgumentException;

final readonly class OctanePatternCache implements PatternCache
{
    /**
     * @throws InvalidArgumentException
     */
    public function get(string $key): ?string
    {
        /** @var string $pattern */
        $pattern = Cache::store('octane')->get($key);

        return $pattern ?: null;
    }

    public function set(string $key, string $pattern): void
    {
        Cache::store('octane')->put($key, $pattern, now()->addDay());
    }
}
