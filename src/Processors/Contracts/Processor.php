<?php

namespace Ninja\Censor\Processors\Contracts;

use Ninja\Censor\Result\Result;

interface Processor
{
    /**
     * @param  array<string>  $chunks
     * @return array<Result>
     */
    public function process(array $chunks): array;
}
