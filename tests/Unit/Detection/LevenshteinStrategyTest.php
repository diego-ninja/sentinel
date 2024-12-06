<?php

namespace Tests\Unit\Detection;

use Ninja\Censor\Detection\LevenshteinStrategy;

test('levenshtein strategy detects similar words', function () {
    $strategy = new LevenshteinStrategy('*', 2);
    $variations = [
        'fuk',
        'phuck',
        'fück'
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, ['fuck']);
        expect($result['matches'])
            ->toHaveCount(1)
            ->sequence(
                fn($match) => $match
                    ->word->toBe($text)
                    ->type->toBe('levenshtein')
            );
    }
});

test('levenshtein strategy respects threshold', function () {
    $strategy = new LevenshteinStrategy('*', 1);
    $result = $strategy->detect('fuk this shet', ['fuck', 'shit']);

    expect($result['matches'])
        ->toHaveCount(2)  // Should only match 'fuk', 'shet' is too different with threshold 1
        ->and($result['matches'][0]['word'])->toBe('fuk');
});

test('levenshtein strategy handles short words correctly', function () {
    $strategy = new LevenshteinStrategy('*', 1);
    $result = $strategy->detect('This is a text', ['shit']);

    // Should not match 'This' with 'shit' even though Levenshtein distance might be within threshold
    expect($result['matches'])->toBeEmpty()
        ->and($result['clean'])->toBe('This is a text');
});

test('levenshtein strategy ignores case in comparisons', function () {
    $strategy = new LevenshteinStrategy('*', 2);
    $result = $strategy->detect('FuK', ['fuck']);

    expect($result['matches'])
        ->toHaveCount(1)
        ->and($result['matches'][0]['word'])->toBe('FuK');
});

test('levenshtein strategy preserves original case in matches', function () {
    $strategy = new LevenshteinStrategy('*', 1);
    $text = 'FuK ThIs ShEt';
    $result = $strategy->detect($text, ['fuck', 'shit']);

    expect($result['matches'])
        ->toHaveCount(2)
        ->sequence(
            fn($match) => $match->word->toBe('FuK'),
            fn($match) => $match->word->toBe('ShEt')
        );
});
