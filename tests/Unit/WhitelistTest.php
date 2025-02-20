<?php

use Ninja\Sentinel\Whitelist;

test('whitelist correctly protects words', function (): void {
    $whitelist = new Whitelist();
    $whitelist->add(['good', 'assistant']);

    $text = 'You are a good assistant';
    expect($whitelist->prepare($text))
        ->not->toBe($text)
        ->and($whitelist->restore($whitelist->prepare($text), true))
        ->toBe($text);
});

test('whitelist handles empty list', function (): void {
    $whitelist = new Whitelist();
    $text = 'test text';

    expect($whitelist->prepare($text))->toBe($text);
});

test('whitelist handles non-string values', function (): void {
    $whitelist = new Whitelist();
    $whitelist->add(['word', 123, null, true]);

    expect($whitelist->prepare('test word'))->not->toBe('test word');
});
