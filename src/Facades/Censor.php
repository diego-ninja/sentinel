<?php

namespace Ninja\Censor\Facades;

use Illuminate\Support\Facades\Facade;
use Ninja\Censor\Enums\Provider;
use Ninja\Censor\Result\Contracts\Result;

/**
 * @method static Result check(string $text)
 * @method static bool offensive(string $text)
 * @method static string clean(string $text)
 * @method static Result|null with(Provider $service, string $text)
 */
class Censor extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'censor';
    }
}
