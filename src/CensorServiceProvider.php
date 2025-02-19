<?php

namespace Ninja\Censor;

use EchoLabs\Prism\Prism;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;
use Ninja\Censor\Cache\Contracts\PatternCache;
use Ninja\Censor\Checkers\Contracts\ProfanityChecker;
use Ninja\Censor\Dictionary\LazyDictionary;
use Ninja\Censor\Enums\Provider;
use Ninja\Censor\Factories\ProfanityCheckerFactory;
use Ninja\Censor\Index\TrieIndex;
use Ninja\Censor\Processors\AbstractProcessor;
use Ninja\Censor\Processors\Contracts\Processor;
use Ninja\Censor\Processors\DefaultProcessor;
use Ninja\Censor\Support\PatternGenerator;

final class CensorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/censor.php' => config_path('censor.php'),
            ], 'censor-config');

            $this->publishes([
                __DIR__.'/../resources/dict' => resource_path('dict'),
            ], 'censor-dictionaries');
        }

        app('validator')->extend(
            rule: 'censor_check',
            extension: function ($attribute, $value, $parameters, Validator $validator) {
                if ($value === null) {
                    return true;
                }

                if (! is_string($value)) {
                    $validator->addReplacer('censor_check', function () {
                        return 'The :attribute must be a string.';
                    });

                    return false;
                }

                return ! \Ninja\Censor\Facades\Censor::check($value)->offensive();
            },
            message: 'The :attribute contains offensive language.'
        );
    }

    public function register(): void
    {
        $this->registerProfanityProviders();

        /** @var Provider $default */
        $default = config('censor.default_service', Provider::Local);
        $this->app->bind(ProfanityChecker::class, function () use ($default): ProfanityChecker {
            /** @var ProfanityChecker $service */
            $service = app($default->value);

            return $service;
        });

        $this->app->singleton(PatternCache::class, function () {
            /** @var string $cache */
            $cache = config('censor.cache', 'file');

            return match ($cache) {
                'redis' => new Cache\RedisPatternCache,
                'octane' => new Cache\OctanePatternCache,
                default => new Cache\MemoryPatternCache,
            };
        });

        $this->app->singleton(PatternGenerator::class, function () {
            /** @var LazyDictionary $dictionary */
            $dictionary = app(LazyDictionary::class);

            return PatternGenerator::withDictionary($dictionary);
        });

        $this->app->singleton(LazyDictionary::class, function (): LazyDictionary {
            /** @var string[] $languages */
            $languages = config('censor.languages', [config('app.locale')]);

            return LazyDictionary::withLanguages($languages);
        });

        $this->app->singleton(Whitelist::class, function (): Whitelist {
            /** @var string[] $whitelist */
            $whitelist = config('censor.whitelist', []);

            return (new Whitelist)->add($whitelist);
        });

        $this->app->singleton(TrieIndex::class, function (): TrieIndex {
            /** @var LazyDictionary $dictionary */
            $dictionary = app(LazyDictionary::class);

            return new TrieIndex($dictionary->getWords());
        });

        $this->app->singleton(Processor::class, function (): AbstractProcessor {
            /** @var class-string<AbstractProcessor> $processorClass */
            $processorClass = config('censor.services.local.processor', DefaultProcessor::class);

            return new $processorClass(
                app(Whitelist::class),
                app(LazyDictionary::class)
            );

        });

        $this->app->bind('censor', function () {
            return new Censor;
        });

        $this->mergeConfigFrom(__DIR__.'/../config/censor.php', 'censor');
    }

    private function registerProfanityProviders(): void
    {
        $services = Provider::values();
        foreach ($services as $service) {
            /** @var array<string,mixed> $config */
            $config = config(sprintf('censor.services.%s', $service->value));

            if ($config !== null) {
                $this->app->singleton($service->value, function () use ($service, $config): ProfanityChecker {
                    return ProfanityCheckerFactory::create($service, $config);
                });
            }
        }

        $this->app->singleton(Provider::Prism->value, function () {
            /** @var Prism $prism */
            $prism = app(Prism::class);

            return new \Ninja\Censor\Checkers\PrismAI(
                prism: $prism
            );
        });

        $this->app->singleton(Provider::Local->value, function () {
            /** @var Processor $processor */
            $processor = app(Processor::class);

            return new \Ninja\Censor\Checkers\Censor(
                processor: $processor
            );
        });
    }
}
