<?php

namespace Tests\Unit\Detection;

use InvalidArgumentException;
use Ninja\Censor\Detection\Strategy\PatternStrategy;
use Ninja\Censor\Enums\MatchType;

test('pattern strategy detects exact matches', function () {
    $patterns = [
        '/\bfuck\b/iu',
        '/\bshit\b/iu',
    ];

    $strategy = new PatternStrategy($patterns);
    $result = $strategy->detect('fuck this shit', ['fuck', 'shit']);

    expect($result)
        ->toHaveCount(2)
        ->sequence(
            fn ($match) => $match
                ->word->toBe('fuck')
                ->type->toBe(MatchType::Pattern),
            fn ($match) => $match
                ->word->toBe('shit')
                ->type->toBe(MatchType::Pattern)
        );

});

test('pattern strategy handles character substitutions', function () {
    $patterns = [
        '/f(u|v)ck/iu',
        '/sh(i|1|!)t/iu',
    ];

    $strategy = new PatternStrategy($patterns);
    $result = $strategy->detect('fvck this sh!t', ['fuck', 'shit']);

    expect($result)
        ->toHaveCount(2)
        ->sequence(
            fn ($match) => $match->word->toBe('fvck'),
            fn ($match) => $match->word->toBe('sh!t')
        );
});

test('pattern strategy respects word boundaries', function () {
    $patterns = ['/\bass\b/iu'];

    $strategy = new PatternStrategy($patterns);
    $result = $strategy->detect('class assignment', ['ass']);

    expect($result)->toBeEmpty();
});

test('pattern strategy handles empty patterns', function () {
    $strategy = new PatternStrategy([]);
    $result = $strategy->detect('some text', []);

    expect($result)->toBeEmpty();
});

test('pattern strategy throws exception for invalid patterns', function () {
    expect(fn () => new PatternStrategy(['/[invalid/'], '*'))
        ->toThrow(
            InvalidArgumentException::class,
        );
});

test('pattern strategy validates all patterns on construction', function () {
    expect(fn () => new PatternStrategy([
        '/valid/i',
        '/[invalid/',
        '/also-invalid[/',
    ], '*'))
        ->toThrow(InvalidArgumentException::class);
});

test('pattern strategy handles unicode and special chars', function () {
    $patterns = ['/f(u|ü|ù)ck/iu'];
    $strategy = new PatternStrategy($patterns);

    $variations = [
        'fück' => true,
        'fùck' => true,
        'føck' => false,
        'f♥ck' => false,
    ];

    foreach ($variations as $text => $shouldMatch) {
        $result = $strategy->detect($text, ['fuck']);
        expect($result->isEmpty())->toBe(! $shouldMatch);
    }
});
