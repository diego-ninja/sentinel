<?php

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Contracts\Language;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Coincidence;
use Ninja\Sentinel\ValueObject\Position;

test('collection calculates score correctly', function (): void {
    /** @var Language $language */
    $language = app(Language::class);

    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score(
                'fuck this shit',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fuck this shit',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(0, 4)]),
            language: $language->code(),
        ),
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score(
                'fuck this shit',
                'shit',
                MatchType::Pattern,
                new OccurrenceCollection([new Position(9, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fuck this shit',
                'shit',
                MatchType::Pattern,
                new OccurrenceCollection([new Position(9, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(9, 4)]),
            language: $language->code(),
        ),
    ]);

    expect($collection->score()->value())->toBeGreaterThan(0.5);
});

test('collection calculates confidence correctly', function (): void {
    /** @var Language $language */
    $language = app(Language::class);

    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score(
                'fuck this shit',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fuck this shit',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(0, 4)]),
            language: $language->code(),
        ),
    ]);

    expect($collection->confidence()->value())->toBeGreaterThanOrEqual(0.85);
});

test('collection determines offensive content correctly', function (): void {
    /** @var Language $language */
    $language = app(Language::class);

    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score(
                'some fuck text',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(5, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'some fuck text',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(5, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(5, 4)]),
            language: $language->code(),
        ),
    ]);

    expect($collection->offensive('some fuck text'))->toBeTrue();
});

test('collection cleans text correctly', function (): void {
    /** @var Language $language */
    $language = app(Language::class);

    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score(
                'fuck this shit',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fuck this shit',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(0, 4)]),
            language: $language->code(),
        ),
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score(
                'fuck this shit',
                'shit',
                MatchType::Pattern,
                new OccurrenceCollection([new Position(9, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fuck this shit',
                'shit',
                MatchType::Pattern,
                new OccurrenceCollection([new Position(9, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(9, 4)]),
            language: $language->code(),
        ),
    ]);

    $text = 'fuck this shit';
    $cleaned = $collection->clean($text);

    expect($cleaned)->toBe('**** this ****');
});

test('collection handles overlapping matches', function (): void {
    /** @var Language $language */
    $language = app(Language::class);

    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score(
                'fucking hell',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fucking hell',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(0, 4)]),
            language: $language->code(),
        ),
        new Coincidence(
            word: 'fucking',
            type: MatchType::Pattern,
            score: Calculator::score(
                'fucking hell',
                'fucking',
                MatchType::Pattern,
                new OccurrenceCollection([new Position(0, 7)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fucking hell',
                'fucking',
                MatchType::Pattern,
                new OccurrenceCollection([new Position(0, 7)]),
            ),
            occurrences: new OccurrenceCollection([new Position(0, 7)]),
            language: $language->code(),
        ),
    ]);

    $text = 'fucking hell';
    $cleaned = $collection->clean($text);

    expect($cleaned)->toBe('******* hell');
});

test('collection returns correct match count', function (): void {
    /** @var Language $language */
    $language = app(Language::class);

    $collection = new MatchCollection([
        new Coincidence(
            word: 'fuck',
            type: MatchType::Exact,
            score: Calculator::score(
                'fuck shit',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fuck shit',
                'fuck',
                MatchType::Exact,
                new OccurrenceCollection([new Position(0, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(0, 4)]),
            language: $language->code(),
        ),
        new Coincidence(
            word: 'shit',
            type: MatchType::Pattern,
            score: Calculator::score(
                'fuck shit',
                'shit',
                MatchType::Pattern,
                new OccurrenceCollection([new Position(5, 4)]),
                $language,
            ),
            confidence: Calculator::confidence(
                'fuck shit',
                'shit',
                MatchType::Pattern,
                new OccurrenceCollection([new Position(5, 4)]),
            ),
            occurrences: new OccurrenceCollection([new Position(5, 4)]),
            language: $language->code(),
        ),
    ]);

    expect($collection)->toHaveCount(2);
});
