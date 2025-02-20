<?php

namespace Ninja\Sentinel\Services\Pipeline\Stage;

use Ninja\Sentinel\Result\Contracts\ResultBuilder;
use Ninja\Sentinel\Services\Contracts\ServiceResponse;
use Ninja\Sentinel\Whitelist;

final class TextStage extends AbstractStage
{
    public function __construct(
        private readonly Whitelist $whitelist,
    ) {}

    public function transform(ServiceResponse $response, ResultBuilder $builder): ResultBuilder
    {
        $replaced = $response->replaced();
        if (null === $replaced && null !== $response->matches()) {
            $replaced = $response->matches()->clean($response->original());
        }

        $replaced ??= $response->original();
        $restored = $this->whitelist->restore($replaced);

        return $builder->withReplaced($restored);
    }
}
