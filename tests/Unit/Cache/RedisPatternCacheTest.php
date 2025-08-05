<?php

use Ninja\Sentinel\Cache\RedisPatternCache;

describe('RedisPatternCache', function () {
    beforeEach(function () {
        $this->cache = new RedisPatternCache();
    });

    it('can instantiate cache without errors', function () {
        $cache = new RedisPatternCache();
        expect($cache)->toBeInstanceOf(RedisPatternCache::class);
    });

    // Other tests require Redis configuration which may not be available in CI
});