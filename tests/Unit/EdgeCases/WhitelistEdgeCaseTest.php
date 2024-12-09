<?php

namespace Tests\Unit\EdgeCases;

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Support\PatternGenerator;
use Ninja\Censor\Whitelist;

test('whitelist handles special regex characters', function () {
    $whitelist = new Whitelist;
    $whitelist->add(['example.com', 'user@email.com', 'path/to/file']);

    $text = 'Contact us at user@email.com or visit example.com';
    $replaced = $whitelist->replace($text);
    $restored = $whitelist->replace($replaced, true);

    expect($restored)->toBe($text);
});

test('whitelist handles overlapping terms', function () {
    $censor = app(Censor::class);
    $whitelist = [
        'assessment',
        'assess',
        'class',
        'skills',
    ];

    $text = 'This class assessment will assess your assessment skills';
    $result = $censor->check($text);

    expect($result->offensive())->toBeFalse();
});
