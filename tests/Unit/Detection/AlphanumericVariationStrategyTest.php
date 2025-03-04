<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\AlphanumericVariationStrategy;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('alphanumeric variation strategy detects numbers mixed with offensive words', function (): void {
    $languages = app(LanguageCollection::class);
    $strategy = new AlphanumericVariationStrategy($languages);

    $variations = [
        'fuck88',
        '123fuck',
        'shit123',
        '456shit',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, $languages->findByCode(LanguageCode::English));

        expect($result)
            ->toHaveCount(1)
            ->sequence(
                fn($match) => $match
                    ->word()->toBe($text)
                    ->type()->toBe(MatchType::Variation),
            );
    }
});

test('alphanumeric variation strategy respects max affix length', function (): void {
    $languages = app(LanguageCollection::class);
    $strategy = new AlphanumericVariationStrategy($languages, 2);

    $result1 = $strategy->detect('fuck88', $languages->findByCode(LanguageCode::English));
    expect($result1)->toHaveCount(1);

    $result2 = $strategy->detect('fuck12345', $languages->findByCode(LanguageCode::English));
    expect($result2)->toBeEmpty();

    $result3 = $strategy->detect('12345fuck', $languages->findByCode(LanguageCode::English));
    expect($result3)->toBeEmpty();
});

test('alphanumeric variation strategy handles edge cases', function (): void {
    $languages = app(LanguageCollection::class);
    $strategy = new AlphanumericVariationStrategy($languages, 2);

    $result = $strategy->detect('this fuck88 should be detected', $languages->findByCode(LanguageCode::English));
    expect($result)->toHaveCount(1);

    $result3 = $strategy->detect('classification', $languages->findByCode(LanguageCode::English));
    expect($result3)->toBeEmpty();
});
