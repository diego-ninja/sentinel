<?php

namespace Ninja\Sentinel\Services\Pipeline\Stage;

use Ninja\Sentinel\Collections\MatchCollection;
use Ninja\Sentinel\Result\Contracts\ResultBuilder;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;

final class MatchesStage extends AbstractStage
{
    public function transform(
        ServiceResponse $response,
        ResultBuilder $builder,
    ): ResultBuilder {
        if (null !== $response->matches()) {
            return $builder
                ->withMatches($response->matches())
                ->withWords($response->matches()->words());
        }

        return $builder
            ->withMatches(new MatchCollection())
            ->withWords([]);
    }
}
