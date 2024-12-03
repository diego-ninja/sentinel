<?php

use Ninja\Censor\Contracts\ProfanityChecker;

if (! function_exists('is_offensive')) {
    function is_offensive(string $text): bool
    {
        /** @var ProfanityChecker $service */
        $service = app(ProfanityChecker::class);

        return $service->check($text)->offensive();
    }
}

if (! function_exists('clean')) {
    function clean(string $text): string
    {
        /** @var ProfanityChecker $service */
        $service = app(ProfanityChecker::class);

        return $service->check($text)->replaced();

    }
}
