<?php

namespace Tests\Unit\Performance;

use Ninja\Sentinel\Analyzers\Local;

test('handles large text input efficiently', function (): void {
    $local = app(Local::class);
    $largeText = str_repeat('This is a very long text with some bad words like fuck and shit scattered throughout. ', 50);

    $startTime = microtime(true);
    $result = $local->analyze($largeText);
    $endTime = microtime(true);

    $executionTime = ($endTime - $startTime);

    expect($result)->toBeOffensive()
        ->and($executionTime)->toBeLessThan(3);
});

test('memory usage stays within acceptable limits', function (): void {
    $local = app(Local::class);
    $largeText = str_repeat('Some text with profanity fuck shit damn repeated many times. ', 100);

    $initialMemory = memory_get_usage();
    $local->analyze($largeText);
    $peakMemory = memory_get_peak_usage() - $initialMemory;

    // Memory usage should be less than 20MB for this operation
    expect($peakMemory)->toBeLessThan(30 * 1024 * 1024);
});

test('multiple dictionary loading performance', function (): void {
    config(['sentinel.languages' => ['en', 'es', 'fr', 'de', 'it']]);

    $startTime = microtime(true);
    $local = app(Local::class);

    $endTime = microtime(true);
    $loadTime = ($endTime - $startTime);

    expect($loadTime)->toBeLessThan(1);
});
