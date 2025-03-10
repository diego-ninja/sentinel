<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Detection\Strategy\SafeContextStrategy;
use Ninja\Sentinel\Enums\ContextType;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('safe language strategy detects educational contexts', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new SafeContextStrategy($languages);

    $text = "In this research paper, we analyze the sexual behavior patterns in animal populations.";
    $result = $strategy->detect($text, $language);

    expect($result)
        ->toBeInstanceOf(MatchCollection::class)
        ->toHaveCount(2)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Educational)
        ->and($result->first()->score()->value())->toBeLessThan(0); // Should be negative
});

test('safe language strategy detects quoted content', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new SafeContextStrategy($languages);

    $text = 'The student said "this assignment is bullshit" during the meeting.';
    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Quoted);
});

test('safe language strategy detects technical contexts', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new SafeContextStrategy($languages);

    $text = 'The developer needed to kill several processes to free up memory.';
    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Technical);
});

test('safe language strategy detects word-specific safe contexts', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new SafeContextStrategy($languages);

    $text = 'The class assignment required students to analyze poetry.';
    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(2)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Educational)
        ->and($result->first()->score()->value())->toBeLessThan(0);
});

test('safe language strategy does not match actual offensive contexts', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new SafeContextStrategy($languages);

    $text = 'That person is a complete ass and everyone knows it.';
    $result = $strategy->detect($text, $language);

    expect($result)->toBeEmpty();
});

test('safe language strategy handles different languages', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::Spanish);
    $strategy = new SafeContextStrategy($languages);

    // Spanish educational language
    $text = 'En este estudio científico, analizamos el comportamiento sexual de los animales.';
    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(1)
        ->and($result->first()->type())->toBe(MatchType::SafeContext)
        ->and($result->first()->context())->toHaveKey('context_type', ContextType::Educational);
});
