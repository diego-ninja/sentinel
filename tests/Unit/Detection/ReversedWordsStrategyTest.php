<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\ReversedWordsStrategy;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('reversed words strategy detects offensive words written backwards', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ReversedWordsStrategy($languages);

    $variations = [
        'kcuf',
        'tihs',
        'hctib',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, $language);

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
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ReversedWordsStrategy($languages);

    $text = "This is a kcuf word that is reversed";

    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(1)
        ->sequence(
            fn($match) => $match
                ->word()->toBe('kcuf')
                ->type()->toBe(MatchType::Variation),
        );
});

test('reversed words strategy preserves language information', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ReversedWordsStrategy($languages);

    $text = "I want to say kcuf";

    $result = $strategy->detect($text, $language);

    expect($result)->toHaveCount(1)
        ->and($result->first()->context())->toHaveKey('original', 'fuck')
        ->and($result->first()->context())->toHaveKey('variation_type', 'reversed');
});

test('reversed words strategy ignores irrelevant reversed words', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ReversedWordsStrategy($languages);

    $text = "This is pots";

    $result = $strategy->detect($text, $language);

    expect($result)->toBeEmpty();
});

test('reversed words strategy only detects full words', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ReversedWordsStrategy($languages);

    $text = "This is kcufs";

    $result = $strategy->detect($text, $language);

    expect($result)->toBeEmpty();
});
