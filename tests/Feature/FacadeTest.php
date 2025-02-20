<?php

namespace Tests\Feature;

use Ninja\Sentinel\Checkers\PurgoMalum;
use Ninja\Sentinel\Enums\Provider;
use Ninja\Sentinel\Facades\Sentinel;
use Ninja\Sentinel\Result\Contracts\Result;
use Ninja\Sentinel\Services\Adapters\PurgoMalumAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;

test('facade check method returns result instance', function (): void {
    $result = Sentinel::check('test text');
    expect($result)->toBeInstanceOf(Result::class);
});

test('facade offensive method returns boolean', function (): void {
    $result = Sentinel::offensive('fuck this shit');
    expect($result)->toBeTrue();
});

test('facade clean method returns cleaned string', function (): void {
    $text = 'fuck this shit';
    $result = Sentinel::clean($text);

    expect($result)->toBe('**** this ****');
});

test('facade with method returns correct service result', function (): void {
    // Configure mock response for PurgoMalum
    $this->app->bind('purgomalum', fn($app) => new PurgoMalum(
        new PurgoMalumAdapter(),
        app(TransformationPipeline::class),
        $this->getMockedHttpClient([
            ['result' => '**** text'],
        ]),
    ));

    $result = Sentinel::with(Provider::PurgoMalum, 'bad text');
    expect($result)
        ->toBeInstanceOf(Result::class)
        ->and($result->replaced())->toBe('**** text');
});

test('facade can switch between services while maintaining state', function (): void {
    // Test default service
    $result1 = Sentinel::check('fuck this shit');
    expect($result1->replaced())->toBe('**** this ****');

    // Test PurgoMalum
    $this->app->bind('purgomalum', fn($app) => new PurgoMalum(
        new PurgoMalumAdapter(),
        app(TransformationPipeline::class),
        $this->getMockedHttpClient([
            ['result' => '**** text'],
        ]),
    ));

    $result2 = Sentinel::with(Provider::PurgoMalum, 'bad text');
    expect($result2->replaced())->toBe('**** text');

    // Test we can still use default service
    $result3 = Sentinel::check('fuck this shit');
    expect($result3->replaced())->toBe('**** this ****');
});

test('facade handles invalid input gracefully', function (): void {
    $result = Sentinel::check('');
    expect($result)
        ->toBeInstanceOf(Result::class)
        ->and($result->offensive())->toBeFalse()
        ->and($result->replaced())->toBe('');
});

test('facade respects configuration changes', function (): void {
    // Change mask character
    config(['sentinel.mask_char' => '#']);
    $result = Sentinel::check('fuck this shit');
    expect($result->replaced())->toBe('#### this ####');

    // Reset for other tests
    config(['sentinel.mask_char' => '*']);
});

test('facade is bound in container correctly', function (): void {
    expect(app('sentinel'))->toBeInstanceOf(\Ninja\Sentinel\Sentinel::class);
});
