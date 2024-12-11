<?php

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\Support\Calculator;
use Ninja\Censor\ValueObject\Coincidence;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

test('collection calculates score correctly', function () {
    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score('fuck', 'fuck', MatchType::Exact),
            confidence: Calculator::confidence('fuck', 'fuck', MatchType::Exact),
            context: []
        ),
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score('shit', 'shit', MatchType::Pattern),
            confidence: Calculator::confidence('shit', 'shit', MatchType::Pattern),
            context: []
        ),
    ]);

    $text = 'fuck this shit';
    $score = $collection->score($text);

    expect($score)
        ->toBeInstanceOf(Score::class)
        ->and($score->value())->toBeGreaterThan(0.5);
});

test('collection calculates confidence correctly', function () {
    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score('fuck', 'fuck', MatchType::Exact),
            confidence: Calculator::confidence('fuck', 'fuck', MatchType::Exact),
            context: []
        ),
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score('shit', 'shit', MatchType::Pattern),
            confidence: Calculator::confidence('shit', 'shit', MatchType::Pattern),
            context: []
        ),
    ]);

    $confidence = $collection->confidence();

    expect($confidence)
        ->toBeInstanceOf(Confidence::class)
        ->and($confidence->value())->toBe(0.95);
});

test('collection determines offensive content correctly', function () {
    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score('fuck', 'fuck', MatchType::Exact),
            confidence: Calculator::confidence('fuck', 'fuck', MatchType::Exact),
            context: []
        ),
    ]);

    $text = 'some fuck text';
    expect($collection->offensive($text))->toBeTrue();
});

test('collection cleans text correctly', function () {
    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score('fuck', 'fuck', MatchType::Exact),
            confidence: Calculator::confidence('fuck', 'fuck', MatchType::Exact),
            context: []
        ),
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score('shit', 'shit', MatchType::Pattern),
            confidence: Calculator::confidence('shit', 'shit', MatchType::Pattern),
            context: []
        ),
    ]);

    $text = 'fuck this shit';
    $cleaned = $collection->clean($text);

    expect($cleaned)->toBe('**** this ****');
});

test('empty collection is not offensive', function () {
    $collection = new MatchCollection;
    expect($collection->offensive('clean text'))->toBeFalse();
});

test('collection handles overlapping matches', function () {
    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score('fuck', 'fuck', MatchType::Exact),
            confidence: Calculator::confidence('fuck', 'fuck', MatchType::Exact),
            context: []
        ),
        new Coincidence(
            word: 'fucking',
            type: MatchType::Pattern,
            score: Calculator::score('fucking', 'fucking', MatchType::Pattern),
            confidence: Calculator::confidence('fucking', 'fucking', MatchType::Pattern),
            context: []
        ),
    ]);

    $text = 'fucking hell';
    $cleaned = $collection->clean($text);

    expect($cleaned)->toBe('******* hell');
});

test('collection returns correct match count', function () {
    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score('fuck', 'fuck', MatchType::Exact),
            confidence: Calculator::confidence('fuck', 'fuck', MatchType::Exact),
            context: []
        ),
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score('shit', 'shit', MatchType::Pattern),
            confidence: Calculator::confidence('shit', 'shit', MatchType::Pattern),
            context: []
        ),
    ]);

    expect($collection)->toHaveCount(2);
});

test('collection can be iterated', function () {
    $matches = [
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score('fuck', 'fuck', MatchType::Exact),
            confidence: Calculator::confidence('fuck', 'fuck', MatchType::Exact),
            context: []
        ),
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score('shit', 'shit', MatchType::Pattern),
            confidence: Calculator::confidence('shit', 'shit', MatchType::Pattern),
            context: []
        ),
    ];

    $collection = new MatchCollection($matches);
    $iterations = 0;

    foreach ($collection as $match) {
        expect($match)->toBeInstanceOf(Coincidence::class);
        $iterations++;
    }

    expect($iterations)->toBe(2);
});

test('collection merges correctly', function () {
    $collection1 = new MatchCollection([
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score('shit', 'shit', MatchType::Pattern),
            confidence: Calculator::confidence('shit', 'shit', MatchType::Pattern),
            context: []
        ),
    ]);

    $collection2 = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score('fuck', 'fuck', MatchType::Exact),
            confidence: Calculator::confidence('fuck', 'fuck', MatchType::Exact),
            context: []
        ),
    ]);

    $merged = $collection1->merge($collection2);

    expect($merged)
        ->toHaveCount(2)
        ->and($merged->first()->word())->toBe('shit')
        ->and($merged->last()->word())->toBe('fuck');
});
