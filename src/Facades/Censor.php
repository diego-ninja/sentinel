<?php

namespace Ninja\Censor\Facades;

use Illuminate\Support\Facades\Facade;
use Ninja\Censor\Contracts\Result;

/**
 * @method static Result check(string $text)
 * @method static bool offensive(string $text)
 * @method static string clean(string $text)
 * @method static Result|null with(string $service, string $text)
 */
class Censor extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'censor';
    }
}
