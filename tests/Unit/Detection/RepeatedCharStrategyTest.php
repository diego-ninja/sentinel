<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\RepeatedCharStrategy;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('repeated chars strategy detects repeated characters', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new RepeatedCharStrategy($languages);

    $variations = [
        'fuuuck',
        'fuuuuck',
        'ffuucckk',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, $language);
        expect($result)
            ->toHaveCount(1)
            ->sequence(
                fn($match) => $match
                    ->word()->toBe($text)
                    ->type()->toBe(MatchType::Repeated),
            );
    }
});

test('repeated chars strategy preserves word boundaries', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new RepeatedCharStrategy($languages);

    $result = $strategy->detect('claaass', $language);

    expect($result)->toBeEmpty();
});

test('repeated chars strategy handles multiple words', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new RepeatedCharStrategy($languages);

    $result = $strategy->detect('fuuuck this shiiit', $language);

    expect($result)
        ->toHaveCount(2)
        ->sequence(
            fn($match) => $match->word()->toBe('fuuuck'),
            fn($match) => $match->word()->toBe('shiiit'),
        );
});

test('repeated chars strategy ignores non-repeated characters', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new RepeatedCharStrategy($languages);

    $result = $strategy->detect('fuck', $language);

    expect($result)->toBeEmpty();
});
