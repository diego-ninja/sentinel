<?php

namespace Tests\Unit\EdgeCases;

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Whitelist;

test('whitelist handles special regex characters', function () {
    $whitelist = new Whitelist;
    $whitelist->add(['example.com', 'user@email.com', 'path/to/file']);

    $text = 'Contact us at user@email.com or visit example.com';
    $replaced = $whitelist->prepare($text);
    $restored = $whitelist->restore($replaced, true);

    expect($restored)->toBe($text);
});

test('whitelist handles overlapping terms', function () {
    config(['censor.whitelist' => [
        'assessment',
        'assess',
        'class',
        'skills',
    ]]);

    app()->forgetInstance(Whitelist::class);
    app()->forgetInstance(Censor::class);

    $censor = app(Censor::class);

    $text = 'This class assessment will assess your assessment skills';
    $result = $censor->check($text);

    expect($result->offensive())->toBeFalse();
});
