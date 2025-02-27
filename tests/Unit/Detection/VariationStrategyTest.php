<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\VariationStrategy;
use Ninja\Sentinel\Enums\MatchType;

test('variation strategy detects separated characters', function (): void {
    $strategy = new VariationStrategy(true);
    $result = $strategy->detect('f u c k this', ['fuck']);

    expect($result)
        ->toHaveCount(1)
        ->sequence(
            fn($match) => $match
                ->word()->toBe('f u c k')
                ->type()->toBe(MatchType::Variation),
        );

});

test('variation strategy handles multiple separators', function (): void {
    $strategy = new VariationStrategy(false);
    $variations = [
        'f.u.c.k',
        'f-u-c-k',
        'f_u_c_k',
        'fuck88',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, ['fuck']);

        expect($result)
            ->toHaveCount(1);
    }
});

test('variation strategy handles multiple spaces between characters', function (): void {
    $strategy = new VariationStrategy(true);
    $result = $strategy->detect('f  u  c  k', ['fuck']);

    expect($result)
        ->toHaveCount(1);
});

test('variation strategy preserves other words', function (): void {
    $strategy = new VariationStrategy(false);
    $result = $strategy->detect('this f.u.c.k test and fuck88 as well', ['fuck']);

    expect($result)
        ->toHaveCount(2);
});
