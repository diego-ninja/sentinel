<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\AlphanumericVariationStrategy;
use Ninja\Sentinel\Enums\MatchType;

test('alphanumeric variation strategy detects numbers mixed with offensive words', function (): void {
    $strategy = new AlphanumericVariationStrategy();

    $variations = [
        'fuck88',
        '123fuck',
        'shit123',
        '456shit',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, ['fuck', 'shit']);

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
    $strategy = new AlphanumericVariationStrategy(2); // Máximo 2 caracteres de prefijo/sufijo

    $result1 = $strategy->detect('fuck88', ['fuck']);
    expect($result1)->toHaveCount(1);

    $result2 = $strategy->detect('fuck12345', ['fuck']);
    expect($result2)->toBeEmpty();

    $result3 = $strategy->detect('12345fuck', ['fuck']);
    expect($result3)->toBeEmpty();
});

test('alphanumeric variation strategy handles edge cases', function (): void {
    $strategy = new AlphanumericVariationStrategy();

    $result = $strategy->detect('this fuck88 should be detected', ['fuck']);
    expect($result)->toHaveCount(1);

    $result3 = $strategy->detect('classification', ['ass']);
    expect($result3)->toBeEmpty();
});
