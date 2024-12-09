<?php

namespace Ninja\Censor\Processors;

final class ParallelProcessor extends AbstractProcessor
{
    public function process(array $chunks): array
    {
        $runtime = new \parallel\Runtime;

        return $runtime->run(function ($chunks) {
            return array_map(fn ($chunk) => $this->processChunk($chunk), $chunks);
        }, [$chunks]);
    }
}
