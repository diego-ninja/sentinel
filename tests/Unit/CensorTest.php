<?php

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Support\PatternGenerator;

test('detects exact matches', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));
    $result = $censor->check('fuck this shit');

    expect($result)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(2)
        ->and($result->replaced())->toBe('**** this ****')
        ->and($result->score())->toBeGreaterThan(0.6);
});

test('detects character replacements', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));
    $variations = [
        'fuuck',
        'sh!t',
        'b!tch',
        'f0ck',
        '@ss',
    ];

    foreach ($variations as $text) {
        $result = $censor->check($text);
        expect($result)
            ->toBeOffensive()
            ->and($result->replaced())->toBe(str_repeat('*', strlen($text)));
    }
});

test('detects separated characters', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));
    $variations = [
        'f u c k',
        'f.u.c.k',
        'f-u-c-k',
        'f_u_c_k',
    ];

    foreach ($variations as $text) {
        $result = $censor->check($text);
        expect($result)
            ->toBeOffensive()
            ->and(strlen($result->replaced()))->toBe(strlen($text));
    }
});

test('detects similar words using levenshtein', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));
    $variations = [
        'fuk',
        'fucc',
        'fück',
        'phuck',
        'phuk',
    ];

    foreach ($variations as $text) {
        $result = $censor->check($text);
        expect($result)
            ->toBeOffensive()
            ->and($result->words())->toHaveCount(1)
            ->and($result->score())->toBeGreaterThanOrEqual(0.7);
    }
});

test('detects offensive phrases using ngrams', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));
    $phrases = [
        'son of a bitch',
        'piece of shit',
        'fuck you',
    ];

    foreach ($phrases as $phrase) {
        $result = $censor->check($phrase);
        expect($result)
            ->toBeOffensive()
            ->and($result->score())->toBeGreaterThan(0.3);
    }
});

test('respects whitelist', function () {
    config(['censor.whitelist' => ['assessment', 'class']]);

    $censor = new Censor(new PatternGenerator(config('censor.replacements')));
    $texts = [
        'assessment',
        'class assessment',
        'assessment class',
    ];

    foreach ($texts as $text) {
        $result = $censor->check($text);
        expect($result)
            ->offensive()->toBeFalse()
            ->and($result->replaced())->toBe($text);
    }
});

test('handles empty and null inputs', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    $result1 = $censor->check('');
    expect($result1)
        ->offensive()->toBeFalse()
        ->and($result1->replaced())->toBe('')
        ->and($result1->score())->toBe(0.0);

    $result2 = $censor->check('   ');
    expect($result2)
        ->offensive()->toBeFalse()
        ->and(trim($result2->replaced()))->toBe('')
        ->and($result2->score())->toBe(0.0);
});

test('calculates appropriate scores', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    // Test different scenarios
    $scenarios = [
        // [text, expected score range]
        ['This is a clean text', [0.0, 0.0]],
        ['fuck shit damn', [0.8, 1.0]],
        ['This text has one fuck word', [0.19, 0.4]],
        ['f u c k this sh!t', [0.7, 1.0]],
    ];

    foreach ($scenarios as [$text, [$min, $max]]) {
        $result = $censor->check($text);
        expect($result->score())
            ->toBeFloat()
            ->toBeGreaterThanOrEqual($min)
            ->toBeLessThanOrEqual($max);
    }
});

test('handles unicode and special characters', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    $texts = [
        'fück' => '****',
        'shït' => '****',
        'fůck' => '****',
        'シット' => 'シット',  // Should not censor Japanese
        'мат' => 'мат',     // Should not censor Russian
    ];

    foreach ($texts as $input => $expected) {
        $result = $censor->check($input);
        expect($result->replaced())->toBe($expected);
    }
});

test('handles repeating characters', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    $variations = [
        'fuuuck',
        'fuuuuck',
        'fuuuuuck',
        'ffuucckk',
    ];

    foreach ($variations as $text) {
        $result = $censor->check($text);
        expect($result)
            ->toBeOffensive()
            ->and(strlen($result->replaced()))->toBe(strlen($text));
    }
});

test('combines multiple detection strategies correctly', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    $text = 'This f.u.c.k contains sh!t and fuuuck';
    $result = $censor->check($text);

    expect($result)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(3)
        ->and($result->score())->toBeGreaterThanOrEqual(0.5);
});
