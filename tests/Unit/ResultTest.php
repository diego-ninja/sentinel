<?php

use Ninja\Sentinel\Checkers\Local;
use Ninja\Sentinel\Result\Result;

test('sentinel result provides all required information', function (): void {
    $local = app(Local::class);
    $result = $local->check('fuck this shit');
    expect($result)
        ->toBeInstanceOf(Result::class)
        ->toBeOffensive()
        ->and($result->words())->toHaveCount(2)
        ->and($result->replaced())->toBe('**** this ****')
        ->and($result->original())->toBe('fuck this shit')
        ->and($result->score()->value())->toBeGreaterThanOrEqual(0.9)
        ->and($result->confidence()->value())->toBeGreaterThanOrEqual(0.7)
        ->and($result->matches())->toHaveCount(2)
        ->and($result->categories())->toBeEmpty();
});
