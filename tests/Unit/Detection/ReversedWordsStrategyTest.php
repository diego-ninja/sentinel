<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\ReversedWordsStrategy;
use Ninja\Sentinel\Enums\MatchType;

test('reversed words strategy detects offensive words written backwards', function (): void {
    $strategy = new ReversedWordsStrategy();

    $variations = [
        'kcuf',
        'tihs',
        'hctib',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, ['fuck', 'shit', 'bitch']);

        expect($result)
            ->toHaveCount(1)
            ->sequence(
                fn($match) => $match
                    ->word()->toBe($text)
                    ->type()->toBe(MatchType::Variation),
            );
    }
});

test('reversed words strategy handles reversed words in sentences', function (): void {
    $strategy = new ReversedWordsStrategy();

    $text = "This is a kcuf word that is reversed";

    $result = $strategy->detect($text, ['fuck']);

    expect($result)
        ->toHaveCount(1)
        ->sequence(
            fn($match) => $match
                ->word()->toBe('kcuf')
                ->type()->toBe(MatchType::Variation),
        );
});

test('reversed words strategy handles unicode characters correctly', function (): void {
    $strategy = new ReversedWordsStrategy();

    $text = "tîhś";

    $result = $strategy->detect($text, ['śhît']);

    expect($result)->toHaveCount(1)
        ->and($result->first()->word())->toBe('tîhś');
});

test('reversed words strategy preserves context information', function (): void {
    $strategy = new ReversedWordsStrategy();

    $text = "I want to say kcuf";

    $result = $strategy->detect($text, ['fuck']);

    expect($result)->toHaveCount(1)
        ->and($result->first()->context())->toHaveKey('original', 'fuck')
        ->and($result->first()->context())->toHaveKey('variation_type', 'reversed');
});

test('reversed words strategy ignores irrelevant reversed words', function (): void {
    $strategy = new ReversedWordsStrategy();

    $text = "This is pots";

    $result = $strategy->detect($text, ['fuck', 'shit', 'bitch']);

    expect($result)->toBeEmpty();
});

test('reversed words strategy only detects full words', function (): void {
    $strategy = new ReversedWordsStrategy();

    $text = "This is kcufs";

    $result = $strategy->detect($text, ['fuck']);

    expect($result)->toBeEmpty();
});
