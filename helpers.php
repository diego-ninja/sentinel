<?php

use Ninja\Sentinel\Actions\AnalyzeAction;
use Ninja\Sentinel\Actions\CleanAction;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Result\Contracts\Result;

if ( ! function_exists('is_offensive')) {
    /**
     * Check if text contains offensive content
     *
     * @param string $text The text to check
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return bool True if the text contains offensive content
     */
    function is_offensive(string $text, ?ContentType $contentType = null, ?Audience $audience = null): bool
    {
        /** @var Result $result */
        $result = AnalyzeAction::run($text, \language(), $contentType, $audience);

        // No need to pass parameters again, the result already has them
        return $result->offensive();
    }
}

if ( ! function_exists('language')) {
    /**
     * Get the language object for the current request
     *
     * @return Language The language object
     */
    function language(): Language
    {
        if (request()->has('language')) {
            /** @var string $language */
            $language = request()->input('language', config('sentinel.default_language', 'en'));
            $languageCode = Ninja\Sentinel\Enums\LanguageCode::from($language);

            return languages()->findByCode($languageCode) ?? languages()->default();
        }

        return languages()->default();
    }
}

if ( ! function_exists('languages')) {
    /**
     * Get the configured languages collection
     *
     * @return Ninja\Sentinel\Language\Collections\LanguageCollection The language object
     */
    function languages(): Ninja\Sentinel\Language\Collections\LanguageCollection
    {
        return app(Ninja\Sentinel\Language\Collections\LanguageCollection::class);
    }
}

if ( ! function_exists('clean')) {
    /**
     * Clean text by replacing offensive content
     *
     * @param string $text The text to clean
     * @param Language|null $language Optional language for analysis
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return string The cleaned text
     */
    function clean(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): string
    {
        /** @var string $result */
        $result = CleanAction::run($text, $language, $contentType, $audience);

        return $result;
    }
}
