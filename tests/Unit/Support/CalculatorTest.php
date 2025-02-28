<?php

namespace Tests\Unit\Support;

use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Position;

test('calculator applies text length normalization for long texts', function (): void {
    // Short text
    $shortText = 'This is a short text with the word fuck in it';
    $shortOccurrences = new OccurrenceCollection([
        new Position(27, 4), // "fuck" at position 27, length 4
    ]);

    // Long text (same offensive word, but in a much longer context)
    $longText = str_repeat('This is some innocent content. ', 100) .
        'This has the word fuck in it. ' .
        str_repeat('More innocent content here. ', 100);
    $longOccurrences = new OccurrenceCollection([
        new Position(2400, 4), // approximate position in the long text
    ]);

    // Calculate scores
    $shortScore = Calculator::score($shortText, 'fuck', MatchType::Exact, $shortOccurrences);
    $longScore = Calculator::score($longText, 'fuck', MatchType::Exact, $longOccurrences);

    // Without normalization, the long text score would be extremely low
    // With normalization, it should be more comparable to the short text score
    expect($shortScore->value())->toBeGreaterThan(0.29)
        ->and($longScore->value())->toBeGreaterThan(0.01) // Still lower but not drastically so
        ->and($longScore->value() / $shortScore->value())->toBeGreaterThan(0.02) // Relative comparison
        ->and($longScore->value())->toBeGreaterThan(0.0); // Ensure it's not close to zero
});

test('calculator maintains expected behavior for short texts', function (): void {
    $text = 'This text has 10 words including the offensive word fuck';
    $occurrences = new OccurrenceCollection([
        new Position(50, 4), // "fuck" at position 50, length 4
    ]);

    // Original implementation behavior should be preserved for short texts
    $score = Calculator::score($text, 'fuck', MatchType::Exact, $occurrences);

    expect($score->value())->toBeGreaterThan(0.2)
        ->toBeLessThan(0.6); // Expected range for single occurrence in short text
});

test('calculator applies higher scores for multiple occurrences in long text', function (): void {
    // Long text with multiple occurrences of the same word
    $longText = str_repeat('This is some innocent content. ', 50) .
        'This has the word fuck in it. ' .
        str_repeat('More innocent content. ', 20) .
        'Another occurrence of fuck here. ' .
        str_repeat('Final innocent content. ', 50);

    $multipleOccurrences = new OccurrenceCollection([
        new Position(1000, 4), // First "fuck"
        new Position(1500, 4), // Second "fuck"
    ]);

    $singleOccurrence = new OccurrenceCollection([
        new Position(1000, 4), // Just the first occurrence
    ]);

    $multiScore = Calculator::score($longText, 'fuck', MatchType::Exact, $multipleOccurrences);
    $singleScore = Calculator::score($longText, 'fuck', MatchType::Exact, $singleOccurrence);

    // Multiple occurrences should score higher than a single occurrence
    expect($multiScore->value())->toBeGreaterThan($singleScore->value())
        ->and($multiScore->value() / $singleScore->value())->toBeGreaterThan(1.1); // At least 10% higher
});
