<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\VariationStrategy;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('variation strategy detects separated characters', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new VariationStrategy($languages, true);

    $result = $strategy->detect('f u c k this', $language);

    expect($result)
        ->toHaveCount(1)
        ->sequence(
            fn($match) => $match
                ->word()->toBe('f u c k')
                ->type()->toBe(MatchType::Variation),
        );

});

test('variation strategy handles multiple separators', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new VariationStrategy($languages, false);

    $variations = [
        'f.u.c.k',
        'f-u-c-k',
        'f_u_c_k',
        'fuck88',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, $language);

        expect($result)
            ->toHaveCount(1);
    }
});

test('variation strategy handles multiple spaces between characters', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new VariationStrategy($languages, true);

    $result = $strategy->detect('f  u  c  k', $language);

    expect($result)
        ->toHaveCount(1);
});

test('variation strategy preserves other words', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new VariationStrategy($languages, false);

    $result = $strategy->detect('this f.u.c.k test and fuck88 as well', $language);

    expect($result)
        ->toHaveCount(2);
});
