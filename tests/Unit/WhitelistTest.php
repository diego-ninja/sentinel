<?php

use Ninja\Censor\Whitelist;

test('whitelist correctly protects words', function () {
    $whitelist = new Whitelist;
    $whitelist->add(['good', 'assistant']);

    $text = 'You are a good assistant';
    expect($whitelist->replace($text))
        ->not->toBe($text)
        ->and($whitelist->replace($whitelist->replace($text), true))
        ->toBe($text);
});

test('whitelist handles empty list', function () {
    $whitelist = new Whitelist;
    $text = 'test text';

    expect($whitelist->replace($text))->toBe($text);
});

test('whitelist handles non-string values', function () {
    $whitelist = new Whitelist;
    $whitelist->add(['word', 123, null, true]);

    expect($whitelist->replace('test word'))->not->toBe('test word');
});
