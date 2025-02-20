<?php

namespace Ninja\Sentinel\Services\Pipeline;

use Ninja\Sentinel\Result\Builder\ResultBuilder;
use Ninja\Sentinel\Result\Result;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;
use Ninja\Sentinel\Services\Pipeline\Stage\AbstractStage;

final class TransformationPipeline
{
    /** @var array<AbstractStage> */
    private array $stages = [];

    public function addStage(AbstractStage $stage): self
    {
        $clone = clone $this;
        $clone->stages[] = $stage;

        return $clone;
    }

    public function process(ServiceResponse $response): Result
    {
        $builder = new ResultBuilder();
        $builder = $builder->withOriginalText($response->original());

        foreach ($this->stages as $stage) {
            $builder = $stage->transform($response, $builder);
        }

        return $builder->build();
    }
}
