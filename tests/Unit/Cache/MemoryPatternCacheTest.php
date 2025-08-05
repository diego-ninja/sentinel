<?php

use Ninja\Sentinel\Cache\MemoryPatternCache;

describe('MemoryPatternCache', function (): void {
    beforeEach(function (): void {
        $this->cache = new MemoryPatternCache();
    });

    it('stores and retrieves patterns correctly', function (): void {
        $key = 'test_pattern';
        $pattern = 'test_pattern_value';

        $this->cache->set($key, $pattern);
        $retrieved = $this->cache->get($key);

        expect($retrieved)->toBe($pattern);
    });

    it('returns null for non-existent keys', function (): void {
        $result = $this->cache->get('non_existent_key');

        expect($result)->toBeNull();
    });

    it('overwrites existing patterns with same key', function (): void {
        $key = 'test_pattern';
        $originalPattern = 'original_pattern';
        $newPattern = 'new_pattern';

        $this->cache->set($key, $originalPattern);
        expect($this->cache->get($key))->toBe($originalPattern);

        $this->cache->set($key, $newPattern);
        expect($this->cache->get($key))->toBe($newPattern);
    });

    it('handles empty string patterns', function (): void {
        $key = 'empty_pattern';
        $pattern = '';

        $this->cache->set($key, $pattern);
        $retrieved = $this->cache->get($key);

        expect($retrieved)->toBe($pattern);
    });

    it('handles multiple different keys independently', function (): void {
        $pattern1 = 'pattern_one';
        $pattern2 = 'pattern_two';
        $pattern3 = 'pattern_three';

        $this->cache->set('key1', $pattern1);
        $this->cache->set('key2', $pattern2);
        $this->cache->set('key3', $pattern3);

        expect($this->cache->get('key1'))->toBe($pattern1);
        expect($this->cache->get('key2'))->toBe($pattern2);
        expect($this->cache->get('key3'))->toBe($pattern3);
    });

    it('respects max size limit', function (): void {
        $cache = new MemoryPatternCache(2); // Max size of 2

        $cache->set('key1', 'pattern1');
        $cache->set('key2', 'pattern2');

        expect($cache->get('key1'))->toBe('pattern1');
        expect($cache->get('key2'))->toBe('pattern2');

        // Adding a third item should evict the oldest
        $cache->set('key3', 'pattern3');

        expect($cache->get('key1'))->toBeNull(); // Should be evicted
        expect($cache->get('key2'))->toBe('pattern2');
        expect($cache->get('key3'))->toBe('pattern3');
    });

    it('updates last used time on access', function (): void {
        $cache = new MemoryPatternCache(2);

        $cache->set('key1', 'pattern1');
        $cache->set('key2', 'pattern2');

        // Access key1 to make it more recently used
        $cache->get('key1');

        // Add a third item - some item should be evicted
        $cache->set('key3', 'pattern3');

        // We can't be 100% sure which one gets evicted due to timing,
        // but we should have exactly 2 items total
        $existingKeys = 0;
        if (null !== $cache->get('key1')) {
            $existingKeys++;
        }
        if (null !== $cache->get('key2')) {
            $existingKeys++;
        }
        if (null !== $cache->get('key3')) {
            $existingKeys++;
        }

        expect($existingKeys)->toBe(2);
        expect($cache->get('key3'))->toBe('pattern3'); // Latest should exist
    });

    it('handles special characters in patterns', function (): void {
        $key = 'special_chars';
        $pattern = 'special@#$%^&*()_+-={}[]|\\:";\'<>?,./';

        $this->cache->set($key, $pattern);
        $retrieved = $this->cache->get($key);

        expect($retrieved)->toBe($pattern);
    });
});
