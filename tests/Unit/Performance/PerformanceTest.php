<?php

namespace Tests\Unit\Performance;

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Dictionary;

test('handles large text input efficiently', function () {
    $censor = new Censor;
    $largeText = str_repeat('This is a very long text with some bad words like fuck and shit scattered throughout. ', 1000);

    $startTime = microtime(true);
    $result = $censor->check($largeText);
    $endTime = microtime(true);

    $executionTime = ($endTime - $startTime);

    expect($result)->toBeOffensive()
        ->and($executionTime)->toBeLessThan(1.0); // Should process in less than 1 second
});

test('memory usage stays within acceptable limits', function () {
    $censor = new Censor;
    $largeText = str_repeat('Some text with profanity fuck shit damn repeated many times. ', 1000);

    $initialMemory = memory_get_usage();
    $censor->check($largeText);
    $peakMemory = memory_get_peak_usage() - $initialMemory;

    // Memory usage should be less than 10MB for this operation
    expect($peakMemory)->toBeLessThan(10 * 1024 * 1024);
});

test('multiple dictionary loading performance', function () {
    $startTime = microtime(true);

    $censor = new Censor;
    foreach (['en', 'es', 'fr', 'de', 'it'] as $lang) {
        $censor->addDictionary(Dictionary::withLanguage($lang));
    }

    $endTime = microtime(true);
    $loadTime = ($endTime - $startTime);

    expect($loadTime)->toBeLessThan(0.5); // Should load in less than 500ms
});
