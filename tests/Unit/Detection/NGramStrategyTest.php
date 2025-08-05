<?php

namespace Tests\Unit\Detection;

use Ninja\Sentinel\Detection\Strategy\NGramStrategy;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Enums\MatchType;
use Ninja\Sentinel\Language\Collections\LanguageCollection;

test('ngram strategy detects offensive phrases', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new NGramStrategy($languages);

    $phrase = 'son of a bitch';
    $words = ['son of a bitch']; // La frase completa debe estar en el diccionario

    $language->words()->addWords($words);

    $result = $strategy->detect($phrase, $language);

    expect($result)
        ->toHaveCount(1)
        ->sequence(
            fn($match) => $match
                ->word()->toBe('son of a bitch')
                ->type()->toBe(MatchType::NGram),
        );

});

test('ngram strategy only matches complete phrases', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new NGramStrategy($languages);

    $result = $strategy->detect('this piece of text', $language);

    expect($result)->toBeEmpty();
});

test('ngram strategy handles case insensitive matches', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new NGramStrategy($languages);

    $language->words()->addWords(['son of a bitch']);
    $result = $strategy->detect('Son Of A Bitch', $language);

    expect($result)
        ->toHaveCount(1);
});

test('ngram strategy ignores single words', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new NGramStrategy($languages);

    $result = $strategy->detect('bad word', $language);

    expect($result)->toBeEmpty();
});

test('ngram strategy handles overlapping phrases correctly', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new NGramStrategy($languages);

    $text = 'piece of shit happens';
    $words = [
        'piece of shit',
        'shit happens',
    ];

    $language->words()->addWords($words);

    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(2)
        ->sequence(
            fn($match) => $match->word()->toBe('piece of shit'),
            fn($match) => $match->word()->toBe('shit happens'),
        );
});

test('ngram strategy only matches phrases from dictionary', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new NGramStrategy($languages);

    $text = 'this is a random combination of words';
    $words = ['specific phrase', 'another phrase'];

    $language->words()->addWords($words);

    $result = $strategy->detect($text, $language);

    expect($result)->toBeEmpty();
});

test('ngram strategy handles phrases with special characters', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new NGramStrategy($languages);

    $text = "What's your problem?";
    $words = ["what's your problem"];

    $language->words()->addWords($words);

    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(1);
});

test('ngram strategy preserves punctuation and spacing', function (): void {
    $languages = app(LanguageCollection::class);
    $language = $languages->findByCode(LanguageCode::English);
    $strategy = new NGramStrategy($languages);

    $text = 'Well, son of a bitch!';
    $words = ['son of a bitch'];

    $language->words()->addWords($words);

    $result = $strategy->detect($text, $language);

    expect($result)
        ->toHaveCount(1);
});
