<?php

namespace Ninja\Sentinel;

use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Enums\Provider;
use Ninja\Sentinel\Result\Contracts\Result;

class Sentinel
{
    public function check(string $text): Result
    {
        /** @var ProfanityChecker $service */
        $service = app(ProfanityChecker::class);

        return $service->check($text);
    }

    public function offensive(string $text): bool
    {
        /** @var ProfanityChecker $service */
        $service = app(ProfanityChecker::class);

        return $service->check($text)->offensive();
    }

    public function clean(string $text): string
    {
        /** @var ProfanityChecker $service */
        $service = app(ProfanityChecker::class);

        return $service->check($text)->replaced();
    }

    public function with(Provider $service, string $text): ?Result
    {
        /** @var ProfanityChecker $checker */
        $checker = app($service->value);

        return $checker->check($text);
    }
}
