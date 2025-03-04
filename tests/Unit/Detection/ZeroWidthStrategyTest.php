<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\ZeroWidthStrategy;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('zero width strategy detects zero-width characters in offensive words', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ZeroWidthStrategy($languages);

    $zws = "\u{200B}"; // Zero width space
    $zwj = "\u{200D}"; // Zero width joiner

    $variations = [
        "f{$zws}u{$zws}c{$zws}k",
        "s{$zwj}h{$zwj}i{$zwj}t",
        "a{$zws}s{$zwj}s{$zws}h{$zwj}o{$zws}l{$zwj}e",
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

test('zero width strategy handles mixed zero-width characters', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ZeroWidthStrategy($languages);

    $zws = "\u{200B}"; // Zero width space
    $zwj = "\u{200D}"; // Zero width joiner
    $zwnj = "\u{200C}"; // Zero width non-joiner

    $text = "This is a f{$zws}u{$zwj}c{$zwnj}k word hidden with zero-width chars";

    $result = $strategy->detect($text, $language);

    expect($result)->toHaveCount(1)
        ->and($result->first()->context())->toHaveKey('variation_type', 'zero_width')
        ->and($result->first()->context())->toHaveKey('clean_word', 'fuck');
});

test('zero width strategy ignores text without zero-width characters', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ZeroWidthStrategy($languages);

    $text = "This is just normal text without any hidden content";

    $result = $strategy->detect($text, $language);

    expect($result)->toBeEmpty();
});

test('zero width strategy detects zero-width chars in longer text', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ZeroWidthStrategy($languages);

    $zws = "\u{200B}"; // Zero width space

    $longText = "This is a longer text that contains a hidden b{$zws}i{$zws}t{$zws}c{$zws}h word that should be detected despite being camouflaged with zero-width spaces between each letter";

    $result = $strategy->detect($longText, $language);

    expect($result)
        ->toHaveCount(1)
        ->sequence(
            fn($match) => $match
                ->word()->toContain('b')
                ->word()->toContain('i')
                ->word()->toContain('t')
                ->word()->toContain('c')
                ->word()->toContain('h')
                ->type()->toBe(MatchType::Variation),
        );
});

test('zero width strategy handles word boundaries correctly', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new ZeroWidthStrategy($languages);

    $zws = "\u{200B}"; // Zero width space

    $text = "This is a cl{$zws}ass assignment";

    $result = $strategy->detect($text, $language);

    expect($result)->toBeEmpty();

    $text2 = "This is an a{$zws}s{$zws}s assignment";

    $result2 = $strategy->detect($text2, $language);

    expect($result2)->toHaveCount(1);
});
