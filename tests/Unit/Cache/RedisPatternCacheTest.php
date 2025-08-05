<?php

use Ninja\Sentinel\Cache\RedisPatternCache;

describe('RedisPatternCache', function (): void {
    beforeEach(function (): void {
        $this->cache = new RedisPatternCache();
    });

    it('can instantiate cache without errors', function (): void {
        $cache = new RedisPatternCache();
        expect($cache)->toBeInstanceOf(RedisPatternCache::class);
    });

    // Other tests require Redis configuration which may not be available in CI
});
