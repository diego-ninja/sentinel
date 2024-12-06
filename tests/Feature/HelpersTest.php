<?php

namespace Tests\Feature;

test('is_offensive helper works correctly', function () {
    expect(is_offensive('fuck this shit'))->toBeTrue()
        ->and(is_offensive('clean text'))->toBeFalse();
});

test('clean helper works correctly', function () {
    expect(clean('fuck this shit'))->toBe('**** this ****')
        ->and(clean('clean text'))->toBe('clean text');
});

test('helpers are properly registered', function () {
    expect(function_exists('is_offensive'))->toBeTrue()
        ->and(function_exists('clean'))->toBeTrue();
});
