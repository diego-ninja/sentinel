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
        ->and($result->score()->value())->toBeGreaterThanOrEqual(0.9)
        ->and($result->confidence()->value())->toBeGreaterThanOrEqual(0.7)
        ->and($result->categories())->toBeEmpty();
});
