<?php

namespace Ninja\Sentinel\Services\Pipeline\Stage;

use Ninja\Sentinel\Result\Contracts\ResultBuilder;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;

final class MetadataStage extends AbstractStage
{
    public function transform(
        ServiceResponse $response,
        ResultBuilder $builder,
    ): ResultBuilder {
        return $builder
            ->withConfidence($response->confidence())
            ->withCategories($response->categories())
            ->withSentiment($response->sentiment());
    }
}
