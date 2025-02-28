<?php

namespace Tests\Unit\Support;

use Ninja\Sentinel\Context\ContextLoader;
use Ninja\Sentinel\Context\Exceptions\ContextFileNotFound;

test('context loader loads different languages', function (): void {
    // Make sure we're mocking the resource path to point to our test files
    $this->mock('path', function ($mock): void {
        $mock->shouldReceive('resource')
            ->with('context/en.php')
            ->andReturn(__DIR__ . '/../../../resources/context/en.php');

        $mock->shouldReceive('resource')
            ->with('context/es.php')
            ->andReturn(__DIR__ . '/../../../resources/context/es.php');

        $mock->shouldReceive('resource')
            ->with('context/fr.php')
            ->andReturn(__DIR__ . '/../../../resources/context/fr.php');

        $mock->shouldReceive('resource')
            ->with('context')
            ->andReturn(__DIR__ . '/../../../resources/context');
    });

    // Test English context
    $englishContext = ContextLoader::getContextForLanguage('en');

    // Test Spanish context
    $spanishContext = ContextLoader::getContextForLanguage('es');

    // Test French context
    $frenchContext = ContextLoader::getContextForLanguage('fr');

    // Each language should have the same structure but different content
    expect($englishContext)->toBeArray()
        ->and($englishContext)->toHaveKeys(['intensifiers', 'negative_modifiers', 'positive_modifiers', 'educational_context', 'pronouns', 'quote_words', 'excuse_words', 'language_markers'])
        ->and($spanishContext)->toBeArray()
        ->and($spanishContext)->toHaveKeys(['intensifiers', 'negative_modifiers', 'positive_modifiers', 'educational_context', 'pronouns', 'quote_words', 'excuse_words', 'language_markers'])
        ->and($frenchContext)->toBeArray()
        ->and($frenchContext)->toHaveKeys(['intensifiers', 'negative_modifiers', 'positive_modifiers', 'educational_context', 'pronouns', 'quote_words', 'excuse_words', 'language_markers'])
        ->and($englishContext['intensifiers'])->not->toEqual($spanishContext['intensifiers'])
        ->and($englishContext['intensifiers'])->not->toEqual($frenchContext['intensifiers'])
        ->and($spanishContext['intensifiers'])->not->toEqual($frenchContext['intensifiers']);

    // Content should be different for each language
});

test('context loader gets specific categories', function (): void {
    // Mock resource path
    $this->mock('path', function ($mock): void {
        $mock->shouldReceive('resource')
            ->with('context/en.php')
            ->andReturn(__DIR__ . '/../../../resources/context/en.php');
    });

    // Get specific category
    $intensifiers = ContextLoader::getCategory('en', 'intensifiers');
    $negativeModifiers = ContextLoader::getCategory('en', 'negative_modifiers');

    expect($intensifiers)->toBeArray()
        ->and($intensifiers)->toContain('very', 'fucking', 'absolutely')
        ->and($negativeModifiers)->toBeArray()
        ->and($negativeModifiers)->toContain('hate', 'kill', 'stupid');
});

test('context loader falls back to English for unsupported languages', function (): void {
    // Mock resource path
    $this->mock('path', function ($mock): void {
        $mock->shouldReceive('resource')
            ->with('context/en.php')
            ->andReturn(__DIR__ . '/../../../resources/context/en.php');

        $mock->shouldReceive('resource')
            ->with('context/xx.php')
            ->andReturn('/nonexistent/path/xx.php');
    });

    // Load non-existent language
    $context = ContextLoader::getContextForLanguage('xx');

    // Should fall back to English
    expect($context)->toBeArray()
        ->and($context)->toHaveKey('intensifiers')
        ->and($context['intensifiers'])->toContain('very', 'fucking');
});

test('context loader throws exception if English file is missing', function (): void {
    // Mock resource path to return non-existent path for English
    $this->mock('path', function ($mock): void {
        $mock->shouldReceive('resource')
            ->with('context/en.php')
            ->andReturn('/nonexistent/path/en.php');
    });

    // Should throw exception
    expect(fn() => ContextLoader::getContextForLanguage('en'))->toThrow(ContextFileNotFound::class);
});

test('context loader caches results', function (): void {
    // Mock resource path
    $this->mock('resource_path', function ($mock): void {
        $mock->shouldReceive('resource')
            ->with('context/en.php')
            ->andReturn(__DIR__ . '/../../../resources/context/en.php')
            ->once(); // This is important - expect only one call
    });

    // Call twice
    $context1 = ContextLoader::getContextForLanguage('en');
    $context2 = ContextLoader::getContextForLanguage('en');

    // Results should be same (and path mock ensures it only loaded once)
    expect($context1)->toBe($context2);
});

test('context loader detects supported languages', function (): void {
    // Mock scandir to return fake directory listing
    $this->mock('path', function ($mock): void {
        $mock->shouldReceive('resource')
            ->with('context')
            ->andReturn('/mock/context/path');
    });

    // Mock scandir
    $this->mock('scandir', function ($mock): void {
        $mock->shouldReceive('__invoke')
            ->with('/mock/context/path')
            ->andReturn(['en.php', 'es.php', 'fr.php', '.', '..', 'README.md']);
    });

    $languages = ContextLoader::getSupportedLanguages();

    expect($languages)->toBeArray()
        ->and($languages)->toEqual(['en', 'es', 'fr']);
});
