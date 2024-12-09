<?php

use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Result\AbstractResult;

test('censor result provides all required information', function () {
    $censor = app(Censor::class);
    $result = $censor->check('fuck this shit');
    expect($result)
        ->toBeInstanceOf(AbstractResult::class)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(2)
        ->and($result->replaced())->toBe('**** this ****')
        ->and($result->original())->toBe('fuck this shit')
        ->and($result->score()->value())->toBe(1.0)
        ->and($result->confidence()->value())->toBe(1.0)
        ->and($result->categories())->toBeEmpty();
});
