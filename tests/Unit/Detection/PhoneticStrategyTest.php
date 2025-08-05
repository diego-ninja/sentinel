<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\PhoneticStrategy;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Enums\PhoneticAlgorithm;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('phonetic strategy detects similar sounding offensive words', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new PhoneticStrategy($languages);

    $variations = [
        'fuk',
        'phuck',
        'phak',
        'fak',
        'fukk',
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

test('phonetic strategy works with different phonetic algorithms', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);

    $metaphoneStrategy = new PhoneticStrategy($languages, PhoneticAlgorithm::Metaphone);
    $soundexStrategy = new PhoneticStrategy($languages, PhoneticAlgorithm::Soundex);

    $text = "This is a shet and sounds like shit";

    $metaphoneResult = $metaphoneStrategy->detect($text, $language);
    $soundexResult = $soundexStrategy->detect($text, $language);

    expect($metaphoneResult)->toHaveCount(2)
        ->and($metaphoneResult->first()->word())->toBe('shet');

    expect($soundexResult)->toHaveCount(2)
        ->and($soundexResult->first()->word())->toBe('shet');
});

test('phonetic strategy ignores unrelated words', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new PhoneticStrategy($languages);

    $text = "This text contains words like food and ship";

    $result = $strategy->detect($text, $language);

    expect($result)->toBeEmpty();
});

test('phonetic strategy handles words in sentences', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new PhoneticStrategy($languages);

    $text = "You are such a beach, I hate you";

    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->context())->toHaveKey('clean_word', 'beach')
        ->and($result->first()->word())->toBe('beach,');
});

test('phonetic strategy handles multiple matches', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new PhoneticStrategy($languages);

    $text = "This is shet and you are a beech";

    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(2)
        ->and($result[0]->word())->toBe('shet')
        ->and($result[1]->word())->toBe('beech');
});
