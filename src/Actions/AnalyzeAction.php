<?php

namespace Ninja\Sentinel\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Ninja\Sentinel\Analyzers\Contracts\Analyzer;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Enums\LanguageCode;
use Ninja\Sentinel\Http\Requests\TextAnalysisRequest;
use Ninja\Sentinel\Http\Resources\ResultResource;
use Ninja\Sentinel\Language\Collections\LanguageCollection;
use Ninja\Sentinel\Language\Language;
use Ninja\Sentinel\Result\Contracts\Result;

final readonly class AnalyzeAction
{
    use AsAction;

    public function __construct(private Analyzer $analyzer) {}

    /**
     * Check text for offensive content
     *
     * @param string $text The text to check
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result The analysis result
     */
    public function handle(string $text, ?Language $language = null, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        return $this->analyzer->analyze($text, $language, $contentType, $audience);
    }

    /**
     * Handle the action as controller
     *
     * @param TextAnalysisRequest $request The HTTP request
     * @return ResultResource The result resource
     */
    public function asController(TextAnalysisRequest $request): ResultResource
    {
        $result = $this->handle(
            text: $request->text(),
            language: $request->language(),
            contentType: $request->contentType(),
            audience: $request->audience(),
        );
        return new ResultResource($result);
    }
}
