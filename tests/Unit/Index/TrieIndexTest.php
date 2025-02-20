<?php

namespace Tests\Unit\Index;

use Ninja\Sentinel\Dictionary\LazyDictionary;
use Ninja\Sentinel\Index\TrieIndex;

test('trie index works with lazy dictionary', function (): void {
    $words = ['test', 'testing', 'tested'];
    $dictionary = LazyDictionary::withWords($words);

    $index = new TrieIndex($dictionary);

    expect($index->search('test'))->toBeTrue()
        ->and($index->search('testing'))->toBeTrue()
        ->and($index->search('tested'))->toBeTrue()
        ->and($index->search('invalid'))->toBeFalse();
});

test('trie index handles large dictionaries efficiently', function (): void {
    $words = array_map(fn($i) => "word{$i}", range(1, 5000));
    $dictionary = LazyDictionary::withWords($words);

    $memoryBefore = memory_get_usage();
    $index = new TrieIndex($dictionary);
    $memoryAfter = memory_get_usage();

    $memoryUsed = $memoryAfter - $memoryBefore;
    expect($memoryUsed)->toBeLessThan(3 * 1024 * 1024);
});
