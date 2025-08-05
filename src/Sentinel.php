<?php

namespace Ninja\Sentinel;

use Ninja\Sentinel\Analyzers\Contracts\Analyzer;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Enums\Provider;
use Ninja\Sentinel\Exceptions\ClientException;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Result\Contracts\Result;
use Throwable;

class Sentinel
{
    /**
     * Check text for offensive content
     *
     * @param string $text The text to check
     * @param Language|null $language Optional language for analyzing text
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result The analysis result
     * @throws ClientException
     */
    public function check(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        try {
            /** @var Analyzer $service */
            $service = app(Analyzer::class);

            return $service->analyze($text, $language, $contentType, $audience);
        } catch (Throwable $e) {
            /** @var Provider|null $fallbackService */
            $fallbackService = config('sentinel.fallback_service');
            if ($fallbackService) {
                /** @var Analyzer $fallback */
                $fallback = app($fallbackService->value);

                return $fallback->analyze($text, $language, $contentType, $audience);
            }

            throw new ClientException('Error analyzing text', 0, $e);
        }
    }

    /**
     * Check if a text contains offensive content
     *
     * @param string $text The text to check
     * @param Language|null $language Optional language for analyzing text
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return bool True if the text contains offensive content
     * @throws ClientException
     */
    public function offensive(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): bool
    {
        $result = $this->check($text, $language, $contentType, $audience);

        // No need to pass parameters again, they're already incorporated in the result
        return $result->offensive();
    }

    /**
     * Clean text by replacing offensive content
     *
     * @param string $text The text to clean
     * @param Language|null $language Optional language for analyzing text
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return string The cleaned text
     * @throws ClientException
     */
    public function clean(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): string
    {
        $result = $this->check($text, $language, $contentType, $audience);

        // If not offensive, according to the language parameters (already in the result),
        // return the original text
        if ( ! $result->offensive()) {
            return $text;
        }

        return $result->replaced();
    }

    /**
     * Use a specific service to check text
     *
     * @param Provider $service The service to use
     * @param string $text The text to check
     * @param Language|null $language Optional language for analyzing text
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result|null The analysis result
     */
    public function with(Provider $service, string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): ?Result
    {
        /** @var Analyzer $checker */
        $checker = app($service->value);

        return $checker->analyze($text, $language, $contentType, $audience);
    }
}
