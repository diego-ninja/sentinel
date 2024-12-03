<?php

namespace Ninja\Censor;

use Ninja\Censor\Contracts\ProfanityChecker;
use Ninja\Censor\Contracts\Result;
use Ninja\Censor\Enums\Service;

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

    public function with(Service $service, string $text): ?Result
    {
        /** @var ProfanityChecker $checker */
        $checker = app($service->value);

        return $checker->check($text);
    }
}
