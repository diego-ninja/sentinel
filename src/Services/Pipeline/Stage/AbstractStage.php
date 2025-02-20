<?php

namespace Ninja\Sentinel\Services\Pipeline\Stage;

use Ninja\Sentinel\Result\Contracts\ResultBuilder;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;

abstract class AbstractStage
{
    abstract public function transform(
        ServiceResponse $response,
        ResultBuilder $builder,
    ): ResultBuilder;
}
