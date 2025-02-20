<?php

namespace Ninja\Sentinel\Factories;

use EchoLabs\Prism\Prism;
use Illuminate\Contracts\Container\BindingResolutionException;
use Ninja\Sentinel\Checkers\AzureAI;
use Ninja\Sentinel\Checkers\Local;
use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Checkers\PerspectiveAI;
use Ninja\Sentinel\Checkers\PrismAI;
use Ninja\Sentinel\Checkers\PurgoMalum;
use Ninja\Sentinel\Checkers\TisaneAI;
use Ninja\Sentinel\Decorators\CachedProfanityChecker;
use Ninja\Sentinel\Enums\Provider;
use Ninja\Sentinel\Processors\Contracts\Processor;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;
use RuntimeException;

final readonly class ProfanityCheckerFactory
{
    /**
     * @param  array<string,mixed>  $config
     * @throws BindingResolutionException
     */
    public static function create(Provider $service, array $config = []): ProfanityChecker
    {
        $pipeline = app()->make(TransformationPipeline::class);

        /** @var class-string<ProfanityChecker> $class */
        $class = match ($service) {
            Provider::Local => Local::class,
            Provider::Perspective => PerspectiveAI::class,
            Provider::PurgoMalum => PurgoMalum::class,
            Provider::Tisane => TisaneAI::class,
            Provider::Azure => AzureAI::class,
            Provider::Prism => PrismAI::class,
        };

        if ( ! class_exists($class)) {
            throw new RuntimeException(sprintf('The class %s does not exist.', $class));
        }

        $checker = match ($service) {
            Provider::Local => new $class(
                processor: app()->make(Processor::class),
                adapter: app()->make(ServiceAdapter::class),
                pipeline: $pipeline,
            ),
            Provider::Azure => new $class(
                endpoint: $config['endpoint'],
                key: $config['key'],
                version: $config['version'],
                adapter: app()->make(ServiceAdapter::class),
                pipeline: $pipeline,
            ),
            Provider::Perspective, Provider::Tisane => new $class(
                key: $config['key'],
                adapter: app()->make(ServiceAdapter::class),
                pipeline: $pipeline,
            ),
            Provider::PurgoMalum => new $class(
                adapter: app()->make(ServiceAdapter::class),
                pipeline: $pipeline,
            ),
            Provider::Prism => new $class(
                prism: app()->make(Prism::class),
                adapter: app()->make(ServiceAdapter::class),
                pipeline: $pipeline,
            ),
        };

        if (true === config('sentinel.cache.enabled', false)) {
            /** @var int $ttl */
            $ttl = config('sentinel.cache.ttl', 3600);

            return new CachedProfanityChecker($checker, $ttl);
        }

        return $checker;
    }
}
