<?php

namespace Ninja\Censor\Processors;

use Ninja\Censor\Result\Result;

final class DefaultProcessor extends AbstractProcessor
{
    /**
     * @param  array<string>  $chunks
     * @return array<Result>
     */
    public function process(array $chunks): array
    {
        $results = array_map(fn(string $chunk): Result => $this->processChunk($chunk), $chunks);
        return [$this->merge($results)];
    }
}
