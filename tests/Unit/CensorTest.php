<?php

use Ninja\Censor\Checkers\Censor;

test('censor detects basic profanity', function () {
    $censor = new Censor;
    $result = $censor->check('fuck this shit');

    expect($result)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(2)
        ->and($result->replaced())->toBe('**** this ****');
});

test('censor handles character replacements', function () {
    $censor = new Censor;
    $result = $censor->check('fuck this sh!t');

    expect($result)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(2)
        ->and($result->replaced())->toBe('**** this ****');
});

test('censor respects whitelisted words', function () {
    config(['censor.whitelist' => ['assessment']]);

    $censor = new Censor;
    $result = $censor->check('This is an assessment');

    expect($result)
        ->toBeClean()
        ->and($result->replaced())->toBe('This is an assessment');
});

test('censor handles full word matching', function () {
    $censor = new Censor;
    $result = $censor->clean('assessment', true);

    expect($result['matched'])->toBeEmpty()
        ->and($result['clean'])->toBe('assessment');
});

test('censor handles empty strings', function () {
    $censor = new Censor;
    $result = $censor->check('');

    expect($result)
        ->toBeClean()
        ->and($result->words())->toBeEmpty()
        ->and($result->replaced())->toBe('');
});

test('censor handles repeated words', function () {
    $censor = new Censor;
    $result = $censor->check('fuck fuck fuck');

    expect($result->words())
        ->toHaveCount(1)
        ->and($result->replaced())
        ->toBe('**** **** ****');
});

test('censor allows custom replacement character', function () {
    $censor = new Censor;
    $censor->setReplaceChar('#');

    expect($censor->check('fuck')->replaced())->toBe('####');
});
