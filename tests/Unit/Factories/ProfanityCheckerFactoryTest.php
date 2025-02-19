<?php

use Ninja\Censor\Checkers\AzureAI;
use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Checkers\PerspectiveAI;
use Ninja\Censor\Checkers\PurgoMalum;
use Ninja\Censor\Checkers\TisaneAI;
use Ninja\Censor\Decorators\CachedProfanityChecker;
use Ninja\Censor\Enums\Provider;
use Ninja\Censor\Factories\ProfanityCheckerFactory;

test('factory creates correct service instances', function (Provider $service, string $expectedClass): void {
    $config = match ($service) {
        Provider::Azure => ['endpoint' => 'test', 'key' => 'test', 'version' => '2024-09-01'],
        Provider::Perspective, Provider::Tisane => ['key' => 'test'],
        default => [],
    };

    $checker = ProfanityCheckerFactory::create($service, $config);
    expect($checker)->toBeInstanceOf($expectedClass);
})->with([
    [Provider::Local, Censor::class],
    [Provider::PurgoMalum, PurgoMalum::class],
    [Provider::Azure, AzureAI::class],
    [Provider::Perspective, PerspectiveAI::class],
    [Provider::Tisane, TisaneAI::class],
]);

test('factory creates cached decorator when cache is enabled', function (Provider $service, string $expectedClass): void {
    config(['censor.cache.enabled' => true]);
    $config = match ($service) {
        Provider::Azure => ['endpoint' => 'test', 'key' => 'test', 'version' => '2024-09-01'],
        Provider::Perspective, Provider::Tisane => ['key' => 'test'],
        default => [],
    };

    $checker = ProfanityCheckerFactory::create($service, $config, true);
    expect($checker)->toBeInstanceOf(CachedProfanityChecker::class);

})->with([
    [Provider::Local, Censor::class],
    [Provider::PurgoMalum, PurgoMalum::class],
    [Provider::Azure, AzureAI::class],
    [Provider::Perspective, PerspectiveAI::class],
    [Provider::Tisane, TisaneAI::class],
]);
