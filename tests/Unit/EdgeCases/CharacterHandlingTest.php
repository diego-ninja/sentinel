<?php

namespace Tests\Unit\EdgeCases;

use Ninja\Censor\Checkers\Censor;

test('handles unicode characters correctly', function () {
    $censor = app(Censor::class);

    $texts = [
        'fūćk' => 'fūćk',  // Not matched because ū,ć not in replacements
        'シット' => 'シット', // Should not censor Japanese
        'мат' => 'мат',    // Should not censor Russian
        'f♥ck' => 'f♥ck',  // Special characters not in replacements
        'sh!t' => '****',  // Common substitutions
        'fück' => '****',  // German umlaut
        'fûck' => '****',  // French circumflex
    ];

    foreach ($texts as $input => $expected) {
        $result = $censor->check($input)->replaced();
        expect($result)->toBe($expected, "Failed asserting that '$input' is censored as '$expected', got '$result'");
    }
});

test('handles emojis correctly', function () {
    $censor = app(Censor::class);

    $texts = [
        'fuck 🤬' => '**** 🤬',
        '🤬 shit 🤬' => '🤬 **** 🤬',
        '💩 crap 💩' => '💩 **** 💩',
    ];

    foreach ($texts as $input => $expected) {
        $result = $censor->check($input)->replaced();
        expect($result)->toBe($expected, "Failed asserting that '$input' is censored as '$expected', got '$result'");
    }
});

test('handles zero-width characters', function () {
    $censor = app(Censor::class);

    $text = "f\u{200B}u\u{200B}c\u{200B}k"; // Zero-width spaces between letters

    $result = $censor->check($text);

    expect($result->offensive())->toBeTrue()
        ->and($result->replaced())->toBe('****');
});

test('handles mixed case with accents correctly', function () {
    $censor = app(Censor::class);

    $texts = [
        'FüCk' => '****',
        'ShÏt' => '****',
        'crÄp' => '****',
    ];

    foreach ($texts as $input => $expected) {
        $result = $censor->check($input)->replaced();
        expect($result)->toBe($expected, "Failed asserting that '$input' is censored as '$expected', got '$result'");
    }
});

test('respects word boundaries with unicode', function () {
    $censor = app(Censor::class);

    $texts = [
        'scrapped' => 'scrapped',           // Should not censor 'crap'
        'räpeseed' => 'räpeseed',           // Should not censor 'rape'
        'classification' => 'classification',  // Should not censor 'ass'
    ];

    foreach ($texts as $input => $expected) {
        $result = $censor->check($input)->replaced(); // true for full word matching
        expect($result)->toBe($expected, "Failed asserting that '$input' is preserved as '$expected', got '$result'");
    }
});
