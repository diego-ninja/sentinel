<?php

use Ninja\Censor\Checkers\AzureAI;
use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Checkers\PerspectiveAI;
use Ninja\Censor\Checkers\PurgoMalum;
use Ninja\Censor\Checkers\TisaneAI;
use Ninja\Censor\Enums\Service;
use Ninja\Censor\Factories\ProfanityCheckerFactory;

test('factory creates correct service instances', function (Service $service, string $expectedClass) {
    $config = match ($service) {
        Service::Azure => ['endpoint' => 'test', 'key' => 'test', 'version' => '2024-09-01'],
        Service::Perspective, Service::Tisane => ['key' => 'test'],
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
