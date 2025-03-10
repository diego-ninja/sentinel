<?php

namespace Ninja\Sentinel\Language\Exceptions;

use Exception;
use Ninja\Sentinel\Enums\LanguageCode;

final class LanguageFileNotFound extends Exception
{
    /**
     * Create a new exception instance for a specific language file
     *
     * @param LanguageCode $language
     * @return LanguageFileNotFound
     */
    public static function forLanguage(LanguageCode $language): self
    {
        return new self(sprintf('Context file for language %s not found.', $language->name));
    }

}
