<?php

namespace Ninja\Sentinel\Checkers\Contracts;

use Ninja\Sentinel\Result\Contracts\Result;

interface ProfanityChecker
{
    public function check(string $text): Result;
}
