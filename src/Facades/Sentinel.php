<?php

namespace Ninja\Sentinel\Facades;

use Illuminate\Support\Facades\Facade;
use Ninja\Sentinel\Enums\Provider;
use Ninja\Sentinel\Result\Contracts\Result;

/**
 * @method static Result check(string $text)
 * @method static bool offensive(string $text)
 * @method static string clean(string $text)
 * @method static Result|null with(Provider $service, string $text)
 */
class Sentinel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'sentinel';
    }
}
