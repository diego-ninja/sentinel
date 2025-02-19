<?php

namespace Tests\Feature;

test('is_offensive helper works correctly', function (): void {
    expect(is_offensive('fuck this shit'))->toBeTrue()
        ->and(is_offensive('clean text'))->toBeFalse();
});

test('clean helper works correctly', function (): void {
    expect(clean('fuck this shit'))->toBe('**** this ****')
        ->and(clean('clean text'))->toBe('clean text');
});

test('helpers are properly registered', function (): void {
    expect(function_exists('is_offensive'))->toBeTrue()
        ->and(function_exists('clean'))->toBeTrue();
});
