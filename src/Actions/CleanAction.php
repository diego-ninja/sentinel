<?php

namespace Ninja\Sentinel\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Ninja\Sentinel\Analyzers\Contracts\Analyzer;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Language\Language;

final readonly class CleanAction
{
    use AsAction;

    public function __construct(private Analyzer $analyzer) {}

    /**
     * Clean text by replacing offensive content
     *
     * @param string $text The text to clean
     * @param Language|null $language Optional language for analysis
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return string The cleaned text
     */
    public function handle(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): string
    {
        $result = $this->analyzer->analyze($text, $language, $contentType, $audience);

        if ( ! $result->offensive()) {
            return $text;
        }

        return $result->replaced();
    }
}
