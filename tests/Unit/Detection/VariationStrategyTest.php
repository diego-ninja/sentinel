<?php

namespace Tests\Unit\Detection;

use Ninja\Censor\Detection\VariationStrategy;

test('variation strategy detects separated characters', function () {
    $strategy = new VariationStrategy('*', true);
    $result = $strategy->detect('f u c k this', ['fuck']);

    expect($result['matches'])
        ->toHaveCount(1)
        ->sequence(
            fn ($match) => $match
                ->word->toBe('f u c k')
                ->type->toBe('variation')
        )
        ->and($result['clean'])->toBe('******* this');
});

test('variation strategy handles multiple separators', function () {
    $strategy = new VariationStrategy('*', true);
    $variations = [
        'f.u.c.k',
        'f-u-c-k',
        'f_u_c_k',
    ];

    foreach ($variations as $text) {
        $result = $strategy->detect($text, ['fuck']);
        expect($result['matches'])
            ->toHaveCount(1)
            ->and($result['clean'])->toBe(str_repeat('*', strlen($text)));
    }
});

test('variation strategy handles multiple spaces between characters', function () {
    $strategy = new VariationStrategy('*', true);
    $result = $strategy->detect('f  u  c  k', ['fuck']);

    expect($result['matches'])
        ->toHaveCount(1)
        ->and($result['clean'])->toBe('**********');
});

test('variation strategy preserves other words', function () {
    $strategy = new VariationStrategy('*', true);
    $result = $strategy->detect('this f.u.c.k test', ['fuck']);

    expect($result['matches'])
        ->toHaveCount(1)
        ->and($result['clean'])->toBe('this ******* test');
});
