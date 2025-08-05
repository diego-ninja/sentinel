<?php

namespace Ninja\Sentinel\Facades;

use Illuminate\Support\Facades\Facade;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Enums\Provider;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Result\Contracts\Result;

/**
 * @method static Result check(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null)
 * @method static bool offensive(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null)
 * @method static string clean(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null)
 * @method static Result|null with(Provider $service, string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null)
 */
class Sentinel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'sentinel';
    }
}
