<?php

namespace Ninja\Sentinel\Factories;

use EchoLabs\Prism\Prism;
use Illuminate\Contracts\Container\BindingResolutionException;
use Ninja\Sentinel\Analyzers\AzureAI;
use Ninja\Sentinel\Analyzers\Contracts\Analyzer;
use Ninja\Sentinel\Analyzers\Local;
use Ninja\Sentinel\Analyzers\PerspectiveAI;
use Ninja\Sentinel\Analyzers\PrismAI;
use Ninja\Sentinel\Analyzers\TisaneAI;
use Ninja\Sentinel\Decorators\CachedAnalyzer;
use Ninja\Sentinel\Enums\Provider;
use Ninja\Sentinel\Processors\Contracts\Processor;
use Ninja\Sentinel\Services\Contracts\ServiceAdapter;
use Ninja\Sentinel\Services\Pipeline\TransformationPipeline;
use RuntimeException;

final readonly class AnalyzerFactory
{
    /**
     * @param  array<string,mixed>  $config
     * @throws BindingResolutionException
     */
    public static function create(Provider $service, array $config = []): Analyzer
    {
        $pipeline = app()->make(TransformationPipeline::class);

        /** @var class-string<Analyzer> $class */
        $class = match ($service) {
            Provider::Local => Local::class,
            Provider::Perspective => PerspectiveAI::class,
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
            Provider::Prism => new $class(
                prism: app()->make(Prism::class),
                adapter: app()->make(ServiceAdapter::class),
                pipeline: $pipeline,
            ),
        };

        if (true === config('sentinel.cache.enabled', false)) {
            /** @var int $ttl */
            $ttl = config('sentinel.cache.ttl', 3600);

            return new CachedAnalyzer($checker, $ttl);
        }

        return $checker;
    }
}
