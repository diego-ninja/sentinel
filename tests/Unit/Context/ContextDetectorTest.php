<?php

namespace Tests\Unit\Context\Detectors;

use Ninja\Sentinel\Context\Detectors\EducationalContextDetector;
use Ninja\Sentinel\Context\Detectors\QuotedContextDetector;
use Ninja\Sentinel\Context\Detectors\TechnicalContextDetector;
use Ninja\Sentinel\Context\Detectors\WordSpecificContextDetector;
use Ninja\Sentinel\Context\Enums\ContextType;

beforeEach(function (): void {
    // Ensure context files are created for testing
    createContextFiles();
});

test('educational context detector identifies academic contexts', function (): void {
    $detector = new EducationalContextDetector();

    $text = "In this research paper, we analyze the sexual behavior of animals.";
    $words = explode(' ', $text);
    $position = array_search('sexual', $words);

    expect($detector->isInContext($text, 'sexual', $position, $words, 'en'))->toBeTrue()
        ->and($detector->getContextType())->toBe(ContextType::Educational);
});

test('educational context detector identifies safe educational terms', function (): void {
    $detector = new EducationalContextDetector();

    $text = "The penis is a male reproductive organ.";
    $words = explode(' ', $text);
    $position = array_search('penis', $words);

    expect($detector->isInContext($text, 'penis', $position, $words, 'en'))->toBeTrue();
});

test('quoted context detector identifies quoted offensive words', function (): void {
    $detector = new QuotedContextDetector();

    $text = 'The student said "this assignment is bullshit" during class.';
    $words = explode(' ', $text);
    $position = array_search('bullshit"', $words);

    expect($detector->isInContext($text, 'bullshit', $position, $words, 'en'))->toBeTrue()
        ->and($detector->getContextType())->toBe(ContextType::Quoted);
});

test('quoted context detector identifies reported speech', function (): void {
    $detector = new QuotedContextDetector();

    $text = 'The report mentioned fuck as one of the most common swear words.';
    $words = explode(' ', $text);
    $position = array_search('fuck', $words);

    expect($detector->isInContext($text, 'fuck', $position, $words, 'en'))->toBeTrue();
});

test('technical context detector identifies technical terms', function (): void {
    $detector = new TechnicalContextDetector();

    $text = 'The developer needed to kill several processes to free up memory.';
    $words = explode(' ', $text);
    $position = array_search('kill', $words);

    expect($detector->isInContext($text, 'kill', $position, $words, 'en'))->toBeTrue()
        ->and($detector->getContextType())->toBe(ContextType::Technical);
});

test('word specific context detector identifies safe pattern usages', function (): void {
    $detector = new WordSpecificContextDetector();

    $text = 'The class assignment was difficult.';
    $words = explode(' ', $text);
    $position = array_search('assignment', $words);

    expect($detector->isInContext($text, 'ass', $position, $words, 'en'))->toBeTrue()
        ->and($detector->getContextType())->toBe(ContextType::WordSpecific);
});
