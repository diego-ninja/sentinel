<?php

namespace Ninja\Censor\Factories;

use Ninja\Censor\Checkers\AzureAI;
use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Checkers\PerspectiveAI;
use Ninja\Censor\Checkers\PurgoMalum;
use Ninja\Censor\Checkers\TisaneAI;
use Ninja\Censor\Contracts\ProfanityChecker;
use Ninja\Censor\Enums\Service;

final readonly class ProfanityCheckerFactory
{
    /**
     * @param  array<string,mixed>  $config
     */
    public static function create(Service $service, array $config = []): ProfanityChecker
    {
        /** @var class-string<ProfanityChecker> $class */
        $class = match ($service) {
            Service::Censor => Censor::class,
            Service::Perspective => PerspectiveAI::class,
            Service::PurgoMalum => PurgoMalum::class,
            Service::Tisane => TisaneAI::class,
            Service::Azure => AzureAI::class,
        };

        return new $class(...$config);
    }
}
