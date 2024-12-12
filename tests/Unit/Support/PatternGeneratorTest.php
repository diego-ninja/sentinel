<?php

namespace Tests\Unit\Support;

use Ninja\Censor\Dictionary\LazyDictionary;
use Ninja\Censor\Support\PatternGenerator;

test('pattern generator handles lazy dictionary correctly', function () {
    $words = ['test', 'bad', 'word'];
    $dictionary = LazyDictionary::withWords($words);

    $generator = PatternGenerator::withDictionary($dictionary);
    $patterns = $generator->getPatterns();

    expect($patterns)
        ->toBeArray()
        ->each->toBeString()
        ->toHaveCount(3);
});

test('pattern generator creates patterns progressively', function () {
    $words = array_map(fn($i) => "word$i", range(1, 1000));
    $dictionary = LazyDictionary::withWords($words);

    $memoryBefore = memory_get_usage();
    $generator = PatternGenerator::withDictionary($dictionary);
    $memoryAfter = memory_get_usage();

    $memoryDiff = $memoryAfter - $memoryBefore;
    expect($memoryDiff)->toBeLessThan(1024 * 1024); // menos de 1MB
});