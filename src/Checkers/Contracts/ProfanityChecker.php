<?php

namespace Ninja\Censor\Checkers\Contracts;

use Ninja\Censor\Result\Contracts\Result;

interface ProfanityChecker
{
    public function check(string $text): Result;
}
