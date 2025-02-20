<?php

namespace Tests\Unit\EdgeCases;

use Ninja\Sentinel\Checkers\Local;

test('handles unicode characters correctly', function (): void {
    $checker = app(Local::class);

    $texts = [
        'fūćk' => 'fūćk',
        'シット' => 'シット',
        'мат' => 'мат',
        'f♥ck' => '****',
        'sh!t' => '****',
        'fück' => '****',
        'fûck' => '****',
    ];

    foreach ($texts as $input => $expected) {
        $result = $checker->check($input)->replaced();
        expect($result)->toBe($expected, "Failed asserting that '{$input}' is moderated as '{$expected}', got '{$result}'");
    }
});

test('handles emojis correctly', function (): void {
    $checker = app(Local::class);

    $texts = [
        'fuck 🤬' => '**** 🤬',
        '🤬 shit 🤬' => '🤬 **** 🤬',
        '💩 crap 💩' => '💩 **** 💩',
    ];

    foreach ($texts as $input => $expected) {
        $result = $checker->check($input)->replaced();
        expect($result)->toBe($expected, "Failed asserting that '{$input}' is moderated as '{$expected}', got '{$result}'");
    }
});

test('handles mixed case with accents correctly', function (): void {
    $checker = app(Local::class);

    $texts = [
        'FüCk' => '****',
        'ShÏt' => '****',
        'crÄp' => '****',
    ];

    foreach ($texts as $input => $expected) {
        $result = $checker->check($input)->replaced();
        expect($result)->toBe($expected, "Failed asserting that '{$input}' is moderated as '{$expected}', got '{$result}'");
    }
});

test('respects word boundaries with unicode', function (): void {
    $checker = app(Local::class);

    $texts = [
        'scrapped' => 'scrapped',           // Should not moderate 'crap'
        'räpeseed' => 'räpeseed',           // Should not moderate 'rape'
        'classification' => 'classification',  // Should not moderate 'ass'
    ];

    foreach ($texts as $input => $expected) {
        $result = $checker->check($input);
        expect($result->replaced())->toBe($expected, sprintf("Failed asserting that '%s' is preserved as '%s', got '%s'", $input, $expected, $result->replaced()));
    }
});
