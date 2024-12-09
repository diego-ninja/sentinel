<?php

namespace Tests\Unit;

use Ninja\Censor\Dictionary\LazyDictionary;
use Ninja\Censor\Exceptions\DictionaryFileNotFound;

test('dictionary loads words correctly from multiple languages', function () {
    config(['censor.dictionary_path' => __DIR__.'/../../../resources/dict']);
    $dictionary = LazyDictionary::withLanguages(['en', 'es', 'fr']);

    $words = iterator_to_array($dictionary->getWords());

    expect($words)
        ->toBeArray()
        ->toContain('fuck', 'puta', 'merde');
});

test('dictionary handles single language', function () {
    config(['censor.dictionary_path' => __DIR__.'/../../../resources/dict']);
    $dictionary = LazyDictionary::withLanguages(['en']);

    $words = iterator_to_array($dictionary->getWords());

    expect($words)
        ->toBeArray()
        ->toContain('fuck', 'shit')
        ->not->toContain('puta', 'merde');
});

test('dictionary throws exception for non-existent language', function () {
    config(['censor.dictionary_path' => __DIR__.'/../../../resources/dict']);

    expect(fn () => LazyDictionary::withLanguages(['nonexistent']))
        ->toThrow(DictionaryFileNotFound::class);
});

test('dictionary can be created from custom file', function () {
    $file = sys_get_temp_dir().'/test_dict.php';
    file_put_contents($file, '<?php return ["test", "words"];');

    $dictionary = LazyDictionary::fromFile($file);
    $words = iterator_to_array($dictionary->getWords());

    expect($words)
        ->toEqual(['test', 'words']);

    unlink($file);
});

test('dictionary deduplicates words', function () {
    config(['censor.dictionary_path' => __DIR__.'/../../../resources/dict']);
    $dictionary = LazyDictionary::withLanguages(['en', 'en-us']); // en-us includes en base words

    $words = iterator_to_array($dictionary->getWords());
    $uniqueWords = array_unique($words);

    expect(count($words))->toBe(count($uniqueWords));
});

test('dictionary generator can be iterated multiple times', function () {
    config(['censor.dictionary_path' => __DIR__.'/../../../resources/dict']);
    $dictionary = LazyDictionary::withLanguages(['en']);

    $firstRun = iterator_to_array($dictionary->getWords());
    $secondRun = iterator_to_array($dictionary->getWords());

    expect($firstRun)->toBe($secondRun);
});
