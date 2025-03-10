<?php

namespace Ninja\Sentinel\Language;

use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Exceptions\LanguageFileNotFound;

final readonly class LanguageDetector
{
    /**
     * @throws LanguageFileNotFound
     */
    public static function detect(string $text): ?Language
    {
        /** @var string[] $configuredLanguages */
        $configuredLanguages = config('sentinel.languages', ['en']);
        return LanguageCollection::fromConfig($configuredLanguages)->bestFor($text);
    }
}
