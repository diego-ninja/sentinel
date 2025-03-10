<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\AffixStrategy;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('word variant strategy detects suffixes', function (): void {
    $languages = app(LanguageCollection::class);
    $strategy = app(AffixStrategy::class);
    $variations = [
        'fucking',
        'fucked',
        'fucker',
        'fuckers',
        'fucks',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, $languages->findByCode(LanguageCode::English));
        expect($result)
            ->toHaveCount(1)
            ->sequence(
                fn($match) => $match
                    ->word->toBe($text)
                    ->type->toBe(MatchType::Variation),
            );
    }
});

test('word variant strategy detects prefixes', function (): void {
    $languages = app(LanguageCollection::class);

    $strategy = new AffixStrategy($languages);
    $variations = [
        'unfuck',
        'refuck',
        'superfuck',
        'antifuck',
        'outfuck',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, $languages->findByCode(LanguageCode::English));
        expect($result)
            ->toHaveCount(1)
            ->sequence(
                fn($match) => $match
                    ->word->toBe($text)
                    ->type->toBe(MatchType::Variation),
            );
    }
});

test('word variant strategy detects prefix-suffix combinations', function (): void {
    $languages = app(LanguageCollection::class);

    $strategy = new AffixStrategy($languages);
    $variations = [
        'unfucking',
        'refucked',
        'superfucker',
        'antifuckers',
        'outfucked',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, $languages->findByCode(LanguageCode::English));
        expect($result)
            ->toHaveCount(1)
            ->sequence(
                fn($match) => $match
                    ->word->toBe($text)
                    ->type->toBe(MatchType::Variation),
            );
    }
});

test('word variant strategy handles special ending rules', function (): void {
    $languages = app(LanguageCollection::class);
    $strategy = new AffixStrategy($languages);

    $result = $strategy->detect('bitchiest', $languages->findByCode(LanguageCode::English));
    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->word())->toBe('bitchiest');

    $result = $strategy->detect('shitting', $languages->findByCode(LanguageCode::English));
    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->word())->toBe('shitting');
});

test('word variant strategy preserves case', function (): void {
    $languages = app(LanguageCollection::class);
    $strategy = new AffixStrategy($languages);

    $text = 'UnFucking REFUCKED superFUCKER';
    $result = $strategy->detect($text, $languages->findByCode(LanguageCode::English));

    expect($result)
        ->toHaveCount(3)
        ->sequence(
            fn($match) => $match->word->toBe('UnFucking'),
            fn($match) => $match->word->toBe('REFUCKED'),
            fn($match) => $match->word->toBe('superFUCKER'),
        );
});

test('word variant strategy handles multiple words in text', function (): void {
    $languages = app(LanguageCollection::class);
    $strategy = new AffixStrategy($languages);

    $text = 'unfucking shitting superfucker';
    $result = $strategy->detect($text, $languages->findByCode(LanguageCode::English));

    expect($result)->toHaveCount(3);
});
