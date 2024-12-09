<?php

use Ninja\Censor\Dictionary\Dictionary;
use Ninja\Censor\Exceptions\DictionaryFileNotFound;

test('dictionary loads words correctly', function () {
    $dictFile = createTestDictionaryFile();
    $dictionary = Dictionary::fromFile($dictFile);

    expect($dictionary->words())
        ->toBeArray()
        ->toContain(...getTestDictionary());

    unlink($dictFile);
});

test('dictionary handles multiple language files', function () {
    $dictFile = createTestDictionaryFile();
    $dictionary = Dictionary::fromFile($dictFile);

    expect($dictionary->words())
        ->toBeArray()
        ->toContain('fuck', 'shit');

    unlink($dictFile);
});

test('dictionary throws exception for non-existent file', function () {
    $this->expectException(DictionaryFileNotFound::class);
    Dictionary::fromFile('non-existent.php');
});

test('dictionary can be created with words array', function () {
    $words = ['test', 'words'];
    $dictionary = Dictionary::withWords($words);

    expect($dictionary->words())
        ->toBeArray()
        ->toEqual($words);
});
