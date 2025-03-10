<?php

namespace Tests\Unit\Dictionary;

use Ninja\Sentinel\Dictionary\LazyDictionary;

/**
 * @param  array<string>  $words
 */
function createDictFile(array $words, string $dir): string
{
    $path = $dir . '/test.php';
    file_put_contents($path, '<?php return ' . var_export($words, true) . ';');

    return $path;
}

beforeEach(function (): void {
    $this->tempDir = sys_get_temp_dir() . '/dict_tests_' . uniqid();
    mkdir($this->tempDir);
});

afterEach(function (): void {
    if (is_dir($this->tempDir)) {
        array_map('unlink', glob("{$this->tempDir}/*.*"));
        rmdir($this->tempDir);
    }
});

test('lazy dictionary loads words in chunks', function (): void {
    $words = array_map(fn($i) => "word{$i}", range(1, 2500));
    createDictFile($words, $this->tempDir);

    $dictionary = LazyDictionary::withWords($words);
    $loadedWords = [];
    $memoryUsage = [];

    foreach ($dictionary as $word) {
        $loadedWords[] = $word;
        $memoryUsage[] = memory_get_usage();
    }

    // Verificar que todos los chunks mantienen un uso de memoria similar
    $memoryVariance = max($memoryUsage) - min($memoryUsage);
    expect($memoryVariance)->toBeLessThan(1024 * 1024) // menos de 1MB de varianza
        ->and($loadedWords)->toHaveCount(2500)
        ->and($loadedWords)->toContain('word1', 'word2500');
});

test('withWords creates dictionary with custom words', function (): void {
    $customWords = ['test1', 'test2', 'test3'];
    $dictionary = LazyDictionary::withWords($customWords);

    $loadedWords = iterator_to_array($dictionary);

    expect($loadedWords)
        ->toHaveCount(3)
        ->toContain(...$customWords);
});

test('dictionary deduplicates words correctly', function (): void {
    $duplicatedWords = ['word', 'word', 'another', 'another', 'unique'];
    $dictionary = LazyDictionary::withWords($duplicatedWords);

    $loadedWords = iterator_to_array($dictionary);

    expect($loadedWords)
        ->toHaveCount(3)
        ->and($loadedWords)->toMatchArray(['word', 'another', 'unique']);
});

test('dictionary handles empty words correctly', function (): void {
    $words = ['word1', '', 'word2', null, 'word3'];
    $dictionary = LazyDictionary::withWords($words);

    $loadedWords = iterator_to_array($dictionary);
    expect($loadedWords)
        ->toHaveCount(3)
        ->toMatchArray(['word1', 'word2', 'word3']);
});


test('dictionary can be iterated multiple times', function (): void {
    $words = ['test1', 'test2', 'test3'];
    $dictionary = LazyDictionary::withWords($words);

    $firstIteration = iterator_to_array($dictionary);
    $secondIteration = iterator_to_array($dictionary);

    expect($firstIteration)->toBe($secondIteration);
});

test('dictionary works with pattern generator', function (): void {
    $words = ['fuck', 'shit', 'damn'];
    $dictionary = LazyDictionary::withWords($words);

    $patterns = \Ninja\Sentinel\Support\PatternGenerator::withDictionary($dictionary);

    expect($patterns->getPatterns())
        ->toBeArray()
        ->not->toBeEmpty();
});

test('dictionary handles unicode words', function (): void {
    $words = ['föck', 'shít', 'dämn'];
    $dictionary = LazyDictionary::withWords($words);

    $loadedWords = iterator_to_array($dictionary);

    expect($loadedWords)
        ->toHaveCount(3)
        ->toMatchArray($words);
});
