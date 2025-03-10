<?php

namespace Tests\Unit\EdgeCases;

use Ninja\Sentinel\Analyzers\Local;
use Ninja\Sentinel\Whitelist;

test('whitelist handles special regex characters', function (): void {
    $whitelist = new Whitelist();
    $whitelist->add(['example.com', 'user@email.com', 'path/to/file']);

    $text = 'Contact us at user@email.com or visit example.com';
    $replaced = $whitelist->prepare($text);
    $restored = $whitelist->restore($replaced, true);

    expect($restored)->toBe($text);
});

test('whitelist handles overlapping terms', function (): void {
    config(['sentinel.whitelist' => [
        'assessment',
        'assess',
        'class',
        'skills',
    ]]);

    app()->forgetInstance(Whitelist::class);
    app()->forgetInstance(Local::class);

    $local = app(Local::class);

    $text = 'This class assessment will assess your assessment skills';
    $result = $local->analyze($text);

    expect($result->offensive())->toBeFalse();
});
