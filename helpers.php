<?php

use Ninja\Sentinel\Actions\CheckAction;
use Ninja\Sentinel\Actions\CleanAction;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
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
        $result = CheckAction::run($text, $contentType, $audience);

        // No need to pass parameters again, the result already has them
        return $result->offensive();
    }
}

if ( ! function_exists('clean')) {
    /**
     * Clean text by replacing offensive content
     *
     * @param string $text The text to clean
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return string The cleaned text
     */
    function clean(string $text, ?ContentType $contentType = null, ?Audience $audience = null): string
    {
        /** @var string $result */
        $result = CleanAction::run($text, $contentType, $audience);

        return $result;
    }
}
