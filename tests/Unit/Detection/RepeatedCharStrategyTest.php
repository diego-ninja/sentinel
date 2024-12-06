<?php

namespace Tests\Unit\Detection;

use Ninja\Censor\Detection\RepeatedCharStrategy;

test('repeated chars strategy detects repeated characters', function () {
    $strategy = new RepeatedCharStrategy('*');
    $variations = [
        'fuuuck',
        'fuuuuck',
        'ffuucckk',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, ['fuck']);
        expect($result['matches'])
            ->toHaveCount(1)
            ->sequence(
                fn ($match) => $match
                    ->word->toBe($text)
                    ->type->toBe('repeated')
            );
    }
});

test('repeated chars strategy preserves word boundaries', function () {
    $strategy = new RepeatedCharStrategy('*');
    $result = $strategy->detect('claaass', ['ass']);

    expect($result['matches'])->toBeEmpty()
        ->and($result['clean'])->toBe('claaass');
});

test('repeated chars strategy handles multiple words', function () {
    $strategy = new RepeatedCharStrategy('*');
    $result = $strategy->detect('fuuuck this shiiit', ['fuck', 'shit']);

    expect($result['matches'])
        ->toHaveCount(2)
        ->sequence(
            fn ($match) => $match->word->toBe('fuuuck'),
            fn ($match) => $match->word->toBe('shiiit')
        );
});

test('repeated chars strategy ignores non-repeated characters', function () {
    $strategy = new RepeatedCharStrategy('*');
    $result = $strategy->detect('fuck', ['fuck']);

    expect($result['matches'])->toBeEmpty()
        ->and($result['clean'])->toBe('fuck');
});
