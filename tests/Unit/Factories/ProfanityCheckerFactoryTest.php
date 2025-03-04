<?php

use Ninja\Sentinel\Checkers\AzureAI;
use Ninja\Sentinel\Checkers\Local;
use Ninja\Sentinel\Checkers\PerspectiveAI;
use Ninja\Sentinel\Checkers\TisaneAI;
use Ninja\Sentinel\Decorators\CachedProfanityChecker;
use Ninja\Sentinel\Enums\Provider;
use Ninja\Sentinel\Factories\ProfanityCheckerFactory;

test('factory creates correct service instances', function (Provider $service, string $expectedClass): void {
    $config = match ($service) {
        Provider::Azure => ['endpoint' => 'test', 'key' => 'test', 'version' => '2024-09-01'],
        Provider::Perspective, Provider::Tisane => ['key' => 'test'],
        default => [],
    };

    $checker = ProfanityCheckerFactory::create($service, $config);
    expect($checker)->toBeInstanceOf($expectedClass);
})->with([
    [Provider::Local, Local::class],
    [Provider::Azure, AzureAI::class],
    [Provider::Perspective, PerspectiveAI::class],
    [Provider::Tisane, TisaneAI::class],
]);

test('factory creates cached decorator when cache is enabled', function (Provider $service, string $expectedClass): void {
    config(['sentinel.cache.enabled' => true]);
    $config = match ($service) {
        Provider::Azure => ['endpoint' => 'test', 'key' => 'test', 'version' => '2024-09-01'],
        Provider::Perspective, Provider::Tisane => ['key' => 'test'],
        default => [],
    };

    $checker = ProfanityCheckerFactory::create($service, $config, true);
    expect($checker)->toBeInstanceOf(CachedProfanityChecker::class);

})->with([
    [Provider::Local, Local::class],
    [Provider::Azure, AzureAI::class],
    [Provider::Perspective, PerspectiveAI::class],
    [Provider::Tisane, TisaneAI::class],
]);
