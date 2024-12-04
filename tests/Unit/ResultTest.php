<?php

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Result\CensorResult;

test('censor result provides all required information', function () {
    $censor = new Censor;
    $result = $censor->check('fuck this shit');

    expect($result)
        ->toBeInstanceOf(CensorResult::class)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(2)
        ->and($result->replaced())->toBe('**** this ****')
        ->and($result->original())->toBe('fuck this shit')
        ->and($result->score())->toBeNull()
        ->and($result->confidence())->toBeNull()
        ->and($result->categories())->toBeNull();
});
