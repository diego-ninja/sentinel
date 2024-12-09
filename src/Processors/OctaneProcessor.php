<?php

namespace Ninja\Censor\Processors;

use Laravel\Octane\Facades\Octane;
use Ninja\Censor\Result\AbstractResult;

final class OctaneProcessor extends AbstractProcessor
{
    public function process(array $chunks): array
    {
        $tasks = [];
        foreach ($chunks as $chunk) {
            $tasks[] = fn () => $this->processChunk($chunk);
        }

        /** @var array<AbstractResult> $results */
        $results = Octane::concurrently($tasks);

        return $results;
    }
}
