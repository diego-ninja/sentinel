<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\PatternStrategy;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Contracts\Language;

test('pattern strategy detects exact matches', function (): void {
    $language = app(Language::class);
    $strategy = app()->build(PatternStrategy::class);
    $result = $strategy->detect('fuck this shit', $language);

    expect($result)
        ->toHaveCount(2)
        ->sequence(
            fn($match) => $match
                ->word()->toBe('fuck')
                ->type()->toBe(MatchType::Pattern),
            fn($match) => $match
                ->word()->toBe('shit')
                ->type()->toBe(MatchType::Pattern),
        );

});

test('pattern strategy handles character substitutions', function (): void {
    $language = app(Language::class);
    $strategy = app()->build(PatternStrategy::class);

    $result = $strategy->detect('fvck this sh!t', $language);

    expect($result)
        ->toHaveCount(2)
        ->sequence(
            fn($match) => $match->word()->toBe('fvck'),
            fn($match) => $match->word()->toBe('sh!t'),
        );
});

test('pattern strategy respects word boundaries', function (): void {
    $language = app(Language::class);
    $strategy = app()->build(PatternStrategy::class);

    $result = $strategy->detect('class assignment', $language);

    expect($result)->toBeEmpty();
});

test('pattern strategy handles empty patterns', function (): void {
    $language = app(Language::class);
    $strategy = app()->build(PatternStrategy::class);

    $result = $strategy->detect('some text', $language);

    expect($result)->toBeEmpty();
});
