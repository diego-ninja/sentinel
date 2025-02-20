<?php

namespace Ninja\Sentinel\Services\Pipeline\Stage;

use Ninja\Sentinel\Result\Contracts\ResultBuilder;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;

class OffensiveStage extends AbstractStage
{
    public function transform(ServiceResponse $response, ResultBuilder $builder): ResultBuilder
    {
        if (null !== $response->matches()) {
            return $builder->withOffensive($response->matches()->offensive());
        }

        return $builder->withOffensive(false);
    }
}
