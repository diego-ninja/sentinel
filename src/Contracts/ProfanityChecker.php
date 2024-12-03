<?php

namespace Ninja\Censor\Contracts;

interface ProfanityChecker
{
    public function check(string $text): Result;
}
