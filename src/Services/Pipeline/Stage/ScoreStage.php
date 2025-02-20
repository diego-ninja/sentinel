<?php

namespace Ninja\Sentinel\Services\Pipeline\Stage;

use Ninja\Sentinel\Result\Contracts\ResultBuilder;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;

final class ScoreStage extends AbstractStage
{
    public function transform(
        ServiceResponse $response,
        ResultBuilder $builder,
    ): ResultBuilder {
        if (null !== $response->score()) {
            return $builder->withScore($response->score());
        }

        if (null !== $response->matches()) {
            return $builder->withScore($response->matches()->score());
        }

        return $builder->withScore(null);
    }
}
