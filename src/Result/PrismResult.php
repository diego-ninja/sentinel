<?php

namespace Ninja\Censor\Result;

final class PrismResult extends AbstractResult
{
    public static function fromResponse(string $text, array $response): AbstractResult
    {
        throw new \RuntimeException('PrismResult does not support fromResponse creation');
    }
}
