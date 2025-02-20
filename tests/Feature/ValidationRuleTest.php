<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;

test('offensive validation rule works for clean text', function (): void {
    $validator = Validator::make(
        ['text' => 'clean text'],
        ['text' => 'required|offensive'],
    );

    expect($validator->passes())->toBeTrue();
});

test('offensive validation rule fails for offensive text', function (): void {
    $validator = Validator::make(
        ['text' => 'fuck this shit'],
        ['text' => 'required|offensive'],
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('text'))
        ->toBe('The text contains offensive language.');
});

test('offensive validation rule handles non-string values', function (): void {
    $validator = Validator::make(
        ['text' => 123],
        ['text' => 'required|offensive'],
    );

    expect($validator->fails())->toBeTrue();
});

test('offensive validation rule can be used with other rules', function (): void {
    $validator = Validator::make(
        ['text' => ''],
        ['text' => 'required|string|offensive'],
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('text'))
        ->toBe('The text field is required.');
});
