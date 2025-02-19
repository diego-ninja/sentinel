<?php

namespace Tests\Unit\Performance;

use Ninja\Censor\Dictionary\Dictionary;

test('dictionary loads large wordlists efficiently', function (): void {
    // Generate large dictionary
    $words = array_map(fn($i) => "word{$i}", range(1, 10000));
    $tempFile = tempnam(sys_get_temp_dir(), 'dict_');
    file_put_contents($tempFile, '<?php return ' . var_export($words, true) . ';');

    $startTime = microtime(true);
    $dictionary = Dictionary::fromFile($tempFile);
    $loadTime = microtime(true) - $startTime;

    expect($dictionary->words())->toHaveCount(10000)
        ->and($loadTime)->toBeLessThan(0.1); // Should load in less than 100ms

    unlink($tempFile);
});

test('dictionary handles duplicate words efficiently', function (): void {
    $words = array_merge(
        array_fill(0, 1000, 'duplicate'),
        range(1, 1000),
    );

    $tempFile = tempnam(sys_get_temp_dir(), 'dict_');
    file_put_contents($tempFile, '<?php return ' . var_export($words, true) . ';');

    $dictionary = Dictionary::fromFile($tempFile);

    expect($dictionary->words())->toHaveCount(1001); // 1000 numbers + 1 duplicate

    unlink($tempFile);
});
