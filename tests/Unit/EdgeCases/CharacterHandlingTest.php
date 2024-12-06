<?php

namespace Tests\Unit\EdgeCases;

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Support\PatternGenerator;

beforeEach(function () {
    config([
        'censor.replacements' => [
            'a' => '(a|@|4|Á|á|À|à|Â|â|Ä|ä|Ã|ã|Å|å|α)',
            'b' => '(b|8|\|3|ß|Β|β)',
            'e' => '(e|3|€|È|è|É|é|Ê|ê|ë|Ë)',
            'i' => '(i|1|!|\||\]\[|]|Ì|í|Î|ï)',
            'l' => '(l|1|\||\]\[|]|£)',
            'o' => '(o|0|Ο|ο|Φ|¤|°|ø|ö|ó|ò|ô|õ)',
            'u' => '(u|υ|µ|ü|ú|ù|û)',
            'y' => '(y|¥|γ|ÿ|ý|Ÿ|Ý)',
        ],
    ]);
});

test('handles unicode characters correctly', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

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
        $result = $censor->clean($input)['clean'];
        expect($result)->toBe($expected, "Failed asserting that '$input' is censored as '$expected', got '$result'");
    }
});

test('handles emojis correctly', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    $texts = [
        'fuck 🤬' => '**** 🤬',
        '🤬 shit 🤬' => '🤬 **** 🤬',
        '💩 crap 💩' => '💩 **** 💩',
    ];

    foreach ($texts as $input => $expected) {
        $result = $censor->clean($input)['clean'];
        expect($result)->toBe($expected, "Failed asserting that '$input' is censored as '$expected', got '$result'");
    }
});

test('handles zero-width characters', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    $text = "f\u{200B}u\u{200B}c\u{200B}k"; // Zero-width spaces between letters

    expect($censor->check($text)->offensive())->toBeTrue()
        ->and($censor->clean($text)['clean'])->toBe('****');
});

test('handles mixed case with accents correctly', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    $texts = [
        'FüCk' => '****',
        'ShÏt' => '****',
        'crÄp' => '****',
    ];

    foreach ($texts as $input => $expected) {
        $result = $censor->clean($input)['clean'];
        expect($result)->toBe($expected, "Failed asserting that '$input' is censored as '$expected', got '$result'");
    }
});

test('respects word boundaries with unicode', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));

    $texts = [
        'scrapped' => 'scrapped',           // Should not censor 'crap'
        'räpeseed' => 'räpeseed',           // Should not censor 'rape'
        'classification' => 'classification',  // Should not censor 'ass'
    ];

    foreach ($texts as $input => $expected) {
        $result = $censor->clean($input, true)['clean']; // true for full word matching
        expect($result)->toBe($expected, "Failed asserting that '$input' is preserved as '$expected', got '$result'");
    }
});
