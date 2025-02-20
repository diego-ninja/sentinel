<?php

namespace Ninja\Sentinel\Exceptions;

use RuntimeException;

final class DictionaryFileNotFound extends RuntimeException
{
    public static function withFile(string $file): self
    {
        return new self('Dictionary file not found: ' . $file);
    }
}
