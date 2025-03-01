<?php

namespace Ninja\Sentinel\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;

final readonly class CleanAction
{
    use AsAction;

    public function __construct(private ProfanityChecker $checker) {}

    /**
     * Clean text by replacing offensive content
     *
     * @param string $text The text to clean
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return string The cleaned text
     */
    public function handle(string $text, ?ContentType $contentType = null, ?Audience $audience = null): string
    {
        $result = $this->checker->check($text, $contentType, $audience);

        if ( ! $result->offensive()) {
            return $text;
        }

        return $result->replaced();
    }
}
