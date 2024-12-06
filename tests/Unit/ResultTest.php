<?php

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Result\CensorResult;
use Ninja\Censor\Support\PatternGenerator;

test('censor result provides all required information', function () {
    $censor = new Censor(new PatternGenerator(config('censor.replacements')));
    $result = $censor->check('fuck this shit');

    expect($result)
        ->toBeInstanceOf(CensorResult::class)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(2)
        ->and($result->replaced())->toBe('**** this ****')
        ->and($result->original())->toBe('fuck this shit')
        ->and($result->score())->toBe(1.0)
        ->and($result->confidence())->toBe(1.0)
        ->and($result->categories())->toBeNull();
});
