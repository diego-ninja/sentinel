<?php

namespace Ninja\Censor;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;
use Ninja\Censor\Contracts\ProfanityChecker;
use Ninja\Censor\Enums\Service;
use Ninja\Censor\Factories\ProfanityCheckerFactory;

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
        $this->registerCheckers();

        /** @var Service $default */
        $default = config('censor.default_service', Service::Local);
        $this->app->bind(ProfanityChecker::class, function () use ($default): ProfanityChecker {
            /** @var ProfanityChecker $service */
            $service = app($default->value);

            return $service;
        });

        $this->app->bind('censor', function () {
            return new Censor;
        });

        $this->mergeConfigFrom(__DIR__.'/../config/censor.php', 'censor');
    }

    private function registerCheckers(): void
    {
        $services = Service::values();
        foreach ($services as $service) {
            /** @var array<string,mixed> $config */
            $config = config(sprintf('censor.services.%s', $service->value));

            if ($config !== null) {
                $this->app->singleton($service->value, function () use ($service, $config): ProfanityChecker {
                    return ProfanityCheckerFactory::create($service, $config);
                });
            }
        }
    }
}
