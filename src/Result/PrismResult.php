<?php

namespace Ninja\Censor\Result;

use RuntimeException;

final class PrismResult extends Result
{
    public static function fromResponse(string $text, array $response): Result
    {
        throw new RuntimeException('PrismResult does not support fromResponse creation');
    }
}
