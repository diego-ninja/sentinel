<?php

namespace Ninja\Sentinel\Decorators;

use Illuminate\Support\Facades\Cache;
use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Result\Contracts\Result;

final readonly class CachedProfanityChecker implements ProfanityChecker
{
    public function __construct(
        private ProfanityChecker $checker,
        private int $ttl = 3600, // 1 hour by default
    ) {}

    public function check(string $text): Result
    {
        $cacheKey = sprintf(
            'sentinel:%s:%s',
            class_basename($this->checker),
            md5($text),
        );

        /** @var string $store */
        $store = config('sentinel.cache.store', 'default');

        /** @var Result $result */
        $result = Cache::store($store)->remember($cacheKey, $this->ttl, fn(): Result => $this->checker->check($text));

        return $result;
    }
}
