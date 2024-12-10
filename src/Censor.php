<?php

namespace Ninja\Censor;

use Ninja\Censor\Checkers\Contracts\ProfanityChecker;
use Ninja\Censor\Enums\Provider;
use Ninja\Censor\Result\Contracts\Result;

class Censor
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
