<?php

use Ninja\Censor\Checkers\AzureAI;
use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Checkers\PerspectiveAI;
use Ninja\Censor\Checkers\PurgoMalum;
use Ninja\Censor\Checkers\TisaneAI;
use Ninja\Censor\Decorators\CachedProfanityChecker;
use Ninja\Censor\Enums\Service;
use Ninja\Censor\Factories\ProfanityCheckerFactory;

test('factory creates correct service instances', function (Service $service, string $expectedClass) {
    $config = match ($service) {
        Service::Azure => ['endpoint' => 'test', 'key' => 'test', 'version' => '2024-09-01'],
        Service::Perspective, Service::Tisane => ['key' => 'test'],
        Service::Local => ['levenshtein_threshold' => 1],
        default => []
    };

    $checker = ProfanityCheckerFactory::create($service, $config);
    expect($checker)->toBeInstanceOf($expectedClass);
})->with([
    [Service::Local, Censor::class],
    [Service::PurgoMalum, PurgoMalum::class],
    [Service::Azure, AzureAI::class],
    [Service::Perspective, PerspectiveAI::class],
    [Service::Tisane, TisaneAI::class],
]);

test('factory creates cached decorator when cache is enabled', function (Service $service, string $expectedClass) {
    config(['censor.cache.enabled' => true]);
    $config = match ($service) {
        Service::Azure => ['endpoint' => 'test', 'key' => 'test', 'version' => '2024-09-01'],
        Service::Perspective, Service::Tisane => ['key' => 'test'],
        Service::Local => ['levenshtein_threshold' => 1],
        default => []
    };

    $checker = ProfanityCheckerFactory::create($service, $config, true);
    expect($checker)->toBeInstanceOf(CachedProfanityChecker::class);

})->with([
    [Service::Local, Censor::class],
    [Service::PurgoMalum, PurgoMalum::class],
    [Service::Azure, AzureAI::class],
    [Service::Perspective, PerspectiveAI::class],
    [Service::Tisane, TisaneAI::class],
]);
