<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\PhoneticStrategy;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Enums\PhoneticAlgorithm;

test('phonetic strategy detects similar sounding offensive words', function (): void {
    $strategy = new PhoneticStrategy();

    $variations = [
        'fuk',
        'phuck',
        'phak',
        'fak',
        'fukk',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, ['fuck']);

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
    $metaphoneStrategy = new PhoneticStrategy(PhoneticAlgorithm::Metaphone);
    $soundexStrategy = new PhoneticStrategy(PhoneticAlgorithm::Soundex);

    $text = "This is a shet that sounds like shit";

    $metaphoneResult = $metaphoneStrategy->detect($text, ['shit']);
    $soundexResult = $soundexStrategy->detect($text, ['shit']);

    expect($metaphoneResult)->toHaveCount(2)
        ->and($metaphoneResult->first()->word())->toBe('shet');

    expect($soundexResult)->toHaveCount(2)
        ->and($soundexResult->first()->word())->toBe('shet');
});

test('phonetic strategy ignores unrelated words', function (): void {
    $strategy = new PhoneticStrategy();

    $text = "This text contains words like food and ship";

    $result = $strategy->detect($text, ['fuck', 'shit']);

    expect($result)->toBeEmpty();
});

test('phonetic strategy handles words in sentences', function (): void {
    $strategy = new PhoneticStrategy();

    $text = "You are such a beach, I hate you";

    $result = $strategy->detect($text, ['bitch']);

    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->context())->toHaveKey('clean_word', 'beach')
        ->and($result->first()->word())->toBe('beach,');
});

test('phonetic strategy handles multiple matches', function (): void {
    $strategy = new PhoneticStrategy();

    $text = "This is shet and you are a beech";

    $result = $strategy->detect($text, ['shit', 'bitch']);

    expect($result)
        ->toHaveCount(2)
        ->and($result[0]->word())->toBe('shet')
        ->and($result[1]->word())->toBe('beech');
});

test('phonetic strategy provides correct context information', function (): void {
    $strategy = new PhoneticStrategy(PhoneticAlgorithm::Metaphone);

    $text = "That was a phuking bad idea";

    $result = $strategy->detect($text, ['fucking']);

    expect($result)->toHaveCount(1)
        ->and($result->first()->context())->toHaveKey('original', 'fucking')
        ->and($result->first()->context())->toHaveKey('variation_type', 'phonetic')
        ->and($result->first()->context())->toHaveKey('algorithm', 'metaphone');
});
