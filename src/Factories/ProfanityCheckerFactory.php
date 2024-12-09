<?php

namespace Ninja\Censor\Factories;

use Ninja\Censor\Checkers\AzureAI;
use Ninja\Censor\Checkers\Censor;
use Ninja\Censor\Checkers\PerspectiveAI;
use Ninja\Censor\Checkers\PurgoMalum;
use Ninja\Censor\Checkers\TisaneAI;
use Ninja\Censor\Contracts\Processor;
use Ninja\Censor\Contracts\ProfanityChecker;
use Ninja\Censor\Decorators\CachedProfanityChecker;
use Ninja\Censor\Enums\Provider;
use RuntimeException;

final readonly class ProfanityCheckerFactory
{
    /**
     * @param  array<string,mixed>  $config
     */
    public static function create(Provider $service, array $config = []): ProfanityChecker
    {
        /** @var class-string<ProfanityChecker> $class */
        $class = match ($service) {
            Provider::Local => Censor::class,
            Provider::Perspective => PerspectiveAI::class,
            Provider::PurgoMalum => PurgoMalum::class,
            Provider::Tisane => TisaneAI::class,
            Provider::Azure => AzureAI::class,
        };

        if (class_exists($class) === false) {
            throw new RuntimeException(sprintf('The class %s does not exist.', $class));
        }

        if ($service === Provider::Local) {
            $checker = new $class(app(Processor::class));
        } else {
            $checker = new $class(...$config);
        }

        if (config('censor.cache.enabled', false) === true) {
            $ttl = config('censor.cache.ttl', 3600);
            if (is_int($ttl) === false) {
                $ttl = 3600;
            }

            return new CachedProfanityChecker($checker, $ttl);
        }

        return $checker;
    }
}
