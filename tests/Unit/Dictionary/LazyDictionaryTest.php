<?php

namespace Tests\Unit;

use Ninja\Censor\Dictionary\LazyDictionary;

test('dictionary loads words correctly from multiple languages', function (): void {
    config(['censor.dictionary_path' => __DIR__ . '/../../../resources/dict']);
    $dictionary = LazyDictionary::withLanguages(['en', 'es', 'fr']);

    $words = iterator_to_array($dictionary->getWords());

    expect($words)
        ->toBeArray()
        ->toContain('fuck', 'puta', 'merde');
});

test('dictionary handles single language', function (): void {
    config(['censor.dictionary_path' => __DIR__ . '/../../../resources/dict']);
    $dictionary = LazyDictionary::withLanguages(['en']);

    $words = iterator_to_array($dictionary->getWords());

    expect($words)
        ->toBeArray()
        ->toContain('fuck', 'shit')
        ->not->toContain('puta', 'merde');
});

test('dictionary deduplicates words', function (): void {
    config(['censor.dictionary_path' => __DIR__ . '/../../../resources/dict']);
    $dictionary = LazyDictionary::withLanguages(['en', 'en-us']); // en-us includes en base words

    $words = iterator_to_array($dictionary->getWords());
    $uniqueWords = array_unique($words);

    expect(count($words))->toBe(count($uniqueWords));
});

test('dictionary generator can be iterated multiple times', function (): void {
    config(['censor.dictionary_path' => __DIR__ . '/../../../resources/dict']);
    $dictionary = LazyDictionary::withLanguages(['en']);

    $firstRun = iterator_to_array($dictionary->getWords());
    $secondRun = iterator_to_array($dictionary->getWords());

    expect($firstRun)->toBe($secondRun);
});
