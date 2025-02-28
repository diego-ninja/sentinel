<?php

namespace Tests\Unit\Support;

use Ninja\Sentinel\Collections\OccurrenceCollection;
use Ninja\Sentinel\Context\ContextModifier;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Support\Calculator;
use Ninja\Sentinel\ValueObject\Position;

test('context modifier reduces score for positive contexts', function (): void {
    // Test with positive context
    $positiveContext = 'This movie is fucking amazing, I love it so much!';
    $positiveOccurrences = new OccurrenceCollection([
        new Position(13, 7), // "fucking" at position 13
    ]);

    // Test with negative context
    $negativeContext = 'I fucking hate this movie, it is terrible!';
    $negativeOccurrences = new OccurrenceCollection([
        new Position(2, 7), // "fucking" at position 2
    ]);

    // Both texts have same offensive word, but different contexts
    $positiveScore = Calculator::score($positiveContext, 'fucking', MatchType::Exact, $positiveOccurrences);
    $negativeScore = Calculator::score($negativeContext, 'fucking', MatchType::Exact, $negativeOccurrences);

    // The positive context should have a lower score than the negative context
    expect($positiveScore->value())->toBeLessThan($negativeScore->value())
        ->and($negativeScore->value() / $positiveScore->value())->toBeGreaterThan(1.2); // At least 20% difference
});

test('context modifier increases score for targeted insults', function (): void {
    // Non-targeted offensive language
    $nonTargeted = 'This movie is fucking awesome.';
    $nonTargetedOccurrences = new OccurrenceCollection([
        new Position(13, 7), // "fucking" at position 13
    ]);

    // Targeted offensive language
    $targeted = 'Fuck you and your stupid ideas.';
    $targetedOccurrences = new OccurrenceCollection([
        new Position(0, 4), // "Fuck" at position 0
    ]);

    $nonTargetedScore = Calculator::score($nonTargeted, 'fucking', MatchType::Exact, $nonTargetedOccurrences, "en");
    $targetedScore = Calculator::score($targeted, 'fuck', MatchType::Exact, $targetedOccurrences, "en");

    // The targeted context should have a significantly higher score
    expect($targetedScore->value())->toBeGreaterThan($nonTargetedScore->value())
        ->and($targetedScore->value() / $nonTargetedScore->value())->toBeGreaterThan(1.1); // At least 30% higher
});

test('context modifier reduces score for educational contexts', function (): void {
    // Offensive word in educational context
    $educationalContext = 'In this research paper we analyze how the word fuck evolved in modern language.';
    $educationalOccurrences = new OccurrenceCollection([
        new Position(46, 4), // "fuck" at position 46
    ]);

    // Same word in offensive context
    $offensiveContext = 'Fuck this assignment, I hate doing homework.';
    $offensiveOccurrences = new OccurrenceCollection([
        new Position(0, 4), // "Fuck" at position 0
    ]);

    $educationalScore = Calculator::score($educationalContext, 'fuck', MatchType::Exact, $educationalOccurrences);
    $offensiveScore = Calculator::score($offensiveContext, 'fuck', MatchType::Exact, $offensiveOccurrences);

    // The educational context should have a significantly lower score
    expect($educationalScore->value())->toBeLessThan($offensiveScore->value())
        ->and($educationalScore->value() / $offensiveScore->value())->toBeLessThan(0.7); // At least 30% lower
});

test('context modifier handles quoted content appropriately', function (): void {
    // Direct offensive content
    $directStatement = 'The product is absolute shit and nobody should buy it.';
    $directOccurrences = new OccurrenceCollection([
        new Position(21, 4), // "shit" at position 21
    ]);

    // Quoted offensive content
    $quotedStatement = 'The customer said "this product is absolute shit" in their review.';
    $quotedOccurrences = new OccurrenceCollection([
        new Position(36, 4), // "shit" at position 36
    ]);

    $directScore = Calculator::score($directStatement, 'shit', MatchType::Exact, $directOccurrences);
    $quotedScore = Calculator::score($quotedStatement, 'shit', MatchType::Exact, $quotedOccurrences);

    // The quoted content should have a lower score
    expect($quotedScore->value())->toBeLessThan($directScore->value())
        ->and($quotedScore->value() / $directScore->value())->toBeLessThan(0.9); // At least 20% lower
});

test('direct use of ContextModifier class returns appropriate modifiers', function (): void {
    // Test positive context
    $positiveText = 'This is an amazing and wonderful example';
    $positiveModifier = ContextModifier::getContextModifier($positiveText, 10, 7); // Middle of text

    // Test negative context
    $negativeText = 'I hate this terrible and awful example';
    $negativeModifier = ContextModifier::getContextModifier($negativeText, 10, 7); // Middle of text

    // Test educational context
    $educationalText = 'In this research we analyze the following example';
    $educationalModifier = ContextModifier::getContextModifier($educationalText, 30, 7); // Middle of text

    expect($positiveModifier)->toBeLessThan(1.0) // Positive should reduce score
        ->and($negativeModifier)->toBeGreaterThan(1.0) // Negative should increase score
        ->and($educationalModifier)->toBeLessThan(0.8); // Educational should significantly reduce score
});
