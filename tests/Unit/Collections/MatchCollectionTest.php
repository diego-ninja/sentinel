<?php

use Ninja\Censor\Collections\MatchCollection;
use Ninja\Censor\Enums\MatchType;
use Ninja\Censor\ValueObject\Coincidence;
use Ninja\Censor\ValueObject\Confidence;
use Ninja\Censor\ValueObject\Score;

test('collection calculates score correctly', function () {
    $collection = new MatchCollection([
        new Coincidence('fuck', MatchType::Exact),
        new Coincidence('shit', MatchType::Pattern),
    ]);

    $text = 'fuck this shit';
    $score = $collection->score($text);

    expect($score)
        ->toBeInstanceOf(Score::class)
        ->and($score->value())->toBeGreaterThan(0.5);
});

test('collection calculates confidence correctly', function () {
    $collection = new MatchCollection([
        new Coincidence('test', MatchType::Exact),
        new Coincidence('word', MatchType::Pattern),
    ]);

    $confidence = $collection->confidence();

    expect($confidence)
        ->toBeInstanceOf(Confidence::class)
        ->and($confidence->value())->toBeGreaterThan(0.5);
});

test('collection determines offensive content correctly', function () {
    $collection = new MatchCollection([
        new Coincidence('fuck', MatchType::Exact),
    ]);

    $text = 'some fuck text';
    expect($collection->offensive($text))->toBeTrue();
});

test('collection cleans text correctly', function () {
    $collection = new MatchCollection([
        new Coincidence('fuck', MatchType::Exact),
        new Coincidence('shit', MatchType::Pattern),
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
        new Coincidence('fuck', MatchType::Exact),
        new Coincidence('fucking', MatchType::Pattern),
    ]);

    $text = 'fucking hell';
    $cleaned = $collection->clean($text);

    expect($cleaned)->toBe('******* hell');
});

test('collection returns correct match count', function () {
    $collection = new MatchCollection([
        new Coincidence('test', MatchType::Exact),
        new Coincidence('word', MatchType::Pattern),
    ]);

    expect($collection)->toHaveCount(2);
});

test('collection can be iterated', function () {
    $matches = [
        new Coincidence('test', MatchType::Exact),
        new Coincidence('word', MatchType::Pattern),
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
        new Coincidence('test', MatchType::Exact),
    ]);

    $collection2 = new MatchCollection([
        new Coincidence('word', MatchType::Pattern),
    ]);

    $merged = $collection1->merge($collection2);

    expect($merged)
        ->toHaveCount(2)
        ->and($merged->first()->word())->toBe('test')
        ->and($merged->last()->word())->toBe('word');
});
