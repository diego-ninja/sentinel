<?php

namespace Ninja\Censor\Decorators;

use Illuminate\Support\Facades\Cache;
use Ninja\Censor\Contracts\ProfanityChecker;
use Ninja\Censor\Result\Contracts\Result;

final readonly class CachedProfanityChecker implements ProfanityChecker
{
    public function __construct(
        private ProfanityChecker $checker,
        private int $ttl = 3600 // 1 hour by default
    ) {}

    public function check(string $text): Result
    {
        $cacheKey = sprintf(
            'censor:%s:%s',
            class_basename($this->checker),
            md5($text)
        );

        /** @var string $store */
        $store = config('censor.cache.store', 'default');

        /** @var Result $result */
        $result = Cache::store($store)->remember($cacheKey, $this->ttl, function () use ($text): Result {
            return $this->checker->check($text);
        });

        return $result;
    }
}
