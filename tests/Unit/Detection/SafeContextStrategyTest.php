<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Context\Enums\ContextType;
use Ninja\Sentinel\Detection\Strategy\SafeContextStrategy;
use Ninja\Sentinel\Enums\MatchType;

test('safe context strategy detects educational contexts', function (): void {
    // Create mock context directories and files for testing
    createContextFiles();

    $strategy = new SafeContextStrategy();
    $text = "In this research paper, we analyze the sexual behavior patterns in animal populations.";
    $result = $strategy->detect($text, ['sexual']);

    expect($result)
        ->toBeInstanceOf(MatchCollection::class)
        ->toHaveCount(1)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Educational)
        ->and($result->first()->score()->value())->toBeLessThan(0); // Should be negative
});

test('safe context strategy detects quoted content', function (): void {
    $strategy = new SafeContextStrategy();
    $text = 'The student said "this assignment is bullshit" during the meeting.';
    $result = $strategy->detect($text, ['bullshit']);

    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Quoted);
});

test('safe context strategy detects technical contexts', function (): void {
    $strategy = new SafeContextStrategy();
    $text = 'The developer needed to kill several processes to free up memory.';
    $result = $strategy->detect($text, ['kill']);

    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Technical);
});

test('safe context strategy detects word-specific safe contexts', function (): void {
    $strategy = new SafeContextStrategy();
    $text = 'The class assignment required students to analyze poetry.';
    $result = $strategy->detect($text, ['ass']);

    expect($result)
        ->toHaveCount(2)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Educational)
        ->and($result->first()->score()->value())->toBeLessThan(0);
});

test('safe context strategy does not match actual offensive contexts', function (): void {
    $strategy = new SafeContextStrategy();
    $text = 'That person is a complete ass and everyone knows it.';
    $result = $strategy->detect($text, ['ass']);

    expect($result)->toBeEmpty();
});

test('safe context strategy handles different languages', function (): void {
    $this->withoutExceptionHandling();

    // Mock config to use Spanish
    config(['sentinel.languages' => ['es']]);

    $strategy = new SafeContextStrategy();

    // Spanish educational context
    $text = 'En este estudio científico, analizamos el comportamiento sexual de los animales.';
    $result = $strategy->detect($text, ['sexual']);

    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Educational);
});