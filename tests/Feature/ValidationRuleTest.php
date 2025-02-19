<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;

test('censor_check validation rule works for clean text', function (): void {
    $validator = Validator::make(
        ['text' => 'clean text'],
        ['text' => 'required|censor_check'],
    );

    expect($validator->passes())->toBeTrue();
});

test('censor_check validation rule fails for offensive text', function (): void {
    $validator = Validator::make(
        ['text' => 'fuck this shit'],
        ['text' => 'required|censor_check'],
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('text'))
        ->toBe('The text contains offensive language.');
});

test('censor_check validation rule handles non-string values', function (): void {
    $validator = Validator::make(
        ['text' => 123],
        ['text' => 'required|censor_check'],
    );

    expect($validator->fails())->toBeTrue();
});

test('censor_check validation rule can be used with other rules', function (): void {
    $validator = Validator::make(
        ['text' => ''],
        ['text' => 'required|string|censor_check'],
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('text'))
        ->toBe('The text field is required.');
});
