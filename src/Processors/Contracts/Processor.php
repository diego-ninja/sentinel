<?php

namespace Ninja\Sentinel\Processors\Contracts;

use Ninja\Sentinel\Result\Result;

interface Processor
{
    /**
     * @param  array<string>  $chunks
     * @return array<Result>
     */
    public function process(array $chunks): array;
}
