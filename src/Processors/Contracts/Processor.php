<?php

namespace Ninja\Censor\Processors\Contracts;

use Ninja\Censor\Result\AbstractResult;

interface Processor
{
    /**
     * @param  array<string>  $chunks
     * @return array<AbstractResult>
     */
    public function process(array $chunks): array;
}
