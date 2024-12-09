<?php

namespace Ninja\Censor\Processors;

use Ninja\Censor\Result\AbstractResult;

final class DefaultProcessor extends AbstractProcessor
{
    /**
     * @param  array<string>  $chunks
     * @return array<AbstractResult>
     */
    public function process(array $chunks): array
    {
        return array_map(fn (string $chunk): AbstractResult => $this->processChunk($chunk), $chunks);
    }
}
