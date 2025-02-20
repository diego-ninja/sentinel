<?php

use Ninja\Sentinel\Checkers\Local;
use Ninja\Sentinel\ValueObject\Score;

test('detects exact matches', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    $result = $local->check('fuck this shit');
    expect($result)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(2)
        ->and($result->replaced())->toBe('**** this ****')
        ->and($result->score()->value())->toBeGreaterThan(0.6);
});

test('detects character replacements', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    $variations = [
        '@ss',
        'fuuck',
        'sh!t',
        'b!tch',
        'f0ck',
    ];

    foreach ($variations as $text) {
        $result = $local->check($text);
        expect($result)
            ->toBeOffensive()
            ->and($result->replaced())->toBe(str_repeat('*', mb_strlen($text)));
    }
});

test('detects separated characters', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    $variations = [
        'f u c k',
        'f.u.c.k',
        'f-u-c-k',
        'f_u_c_k',
    ];

    foreach ($variations as $text) {
        $result = $local->check($text);
        expect($result)
            ->toBeOffensive()
            ->and(mb_strlen($result->replaced()))->toBe(mb_strlen($text));
    }
});

test('detects similar words using levenshtein', function (): void {
    /** @var Local $local */
    $local = app(Local::class);
    $variations = [
        'fück',
        'fucc',
        'fuk',
        'phuck',
        'phuk',
    ];

    foreach ($variations as $text) {
        $result = $local->check($text);
        expect($result)
            ->toBeOffensive()
            ->and($result->words())->toHaveCount(1)
            ->and($result->score()->value())->toBeGreaterThanOrEqual(0.7);
    }
});

test('detects offensive phrases using ngrams', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    $phrases = [
        'fuck you',
        'piece of shit',
        'son of a bitch',
    ];

    foreach ($phrases as $phrase) {
        $result = $local->check($phrase);
        expect($result)
            ->toBeOffensive()
            ->and($result->score()->value())->toBeGreaterThan(0.2);
    }
});

test('respects whitelist', function (): void {
    config(['sentinel.whitelist' => ['assessment', 'class']]);

    /** @var Local $local */
    $local = app(Local::class);

    $texts = [
        'assessment',
        'class assessment',
        'assessment class',
    ];

    foreach ($texts as $text) {
        $result = $local->check($text);
        expect($result)
            ->offensive()->toBeFalse()
            ->and($result->replaced())->toBe($text);
    }
});

test('handles empty and null inputs', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    $result1 = $local->check('');
    expect($result1)
        ->offensive()->toBeFalse()
        ->and($result1->replaced())->toBe('')
        ->and($result1->score()->value())->toBe(0.0);

    $result2 = $local->check('   ');
    expect($result2)
        ->offensive()->toBeFalse()
        ->and(mb_trim($result2->replaced()))->toBe('')
        ->and($result2->score()->value())->toBe(0.0);
});

test('calculates appropriate scores', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    // Test different scenarios
    $scenarios = [
        // [text, expected score range]
        ['This is a clean text', [0.0, 0.0]],
        ['fuck shit damn', [0.8, 1.0]],
        ['This text has one fuck word', [0.1, 0.6]],
        ['f u c k this sh!t', [0.6, 1.0]],
    ];

    foreach ($scenarios as [$text, [$min, $max]]) {
        $result = $local->check($text);
        expect($result->score())
            ->toBeInstanceOf(Score::class)
            ->and($result->score()->value())
            ->toBeGreaterThanOrEqual($min)
            ->toBeLessThanOrEqual($max);

    }
});

test('handles unicode and special characters', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    $texts = [
        'fück' => '****',
        'shït' => '****',
        'fůck' => '****',
        'シット' => 'シット',  // Should not moderate Japanese
        'мат' => 'мат',     // Should not moderate Russian
    ];

    foreach ($texts as $input => $expected) {
        $result = $local->check($input);
        expect($result->replaced())->toBe($expected);
    }
});

test('handles repeating characters', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    $variations = [
        'fuuuck',
        'fuuuuck',
        'fuuuuuck',
        'ffuucckk',
    ];

    foreach ($variations as $text) {
        $result = $local->check($text);
        expect($result)
            ->toBeOffensive()
            ->and(mb_strlen($result->replaced()))->toBe(mb_strlen($text));
    }
});

test('combines multiple detection strategies correctly', function (): void {
    /** @var Local $local */
    $local = app(Local::class);

    $text = 'This f.u.c.k contains sh!t and fuuuck';
    $result = $local->check($text);

    expect($result)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(3)
        ->and($result->score()->value())->toBeGreaterThanOrEqual(0.49);
});
