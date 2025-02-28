<?php

namespace Ninja\Sentinel\Context\Exceptions;

use RuntimeException;

/**
 * Exception thrown when a context file is not found
 */
final class ContextFileNotFound extends RuntimeException
{
    /**
     * Create a new exception instance for a specific context file
     *
     * @param string $language
     * @return static
     */
    public static function forLanguage(string $language): self
    {
        return new self(sprintf('Context file for language "%s" not found.', $language));
    }
}