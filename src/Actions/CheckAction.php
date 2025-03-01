<?php

namespace Ninja\Sentinel\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;
use Ninja\Sentinel\Http\Requests\TextAnalysisRequest;
use Ninja\Sentinel\Http\Resources\ResultResource;
use Ninja\Sentinel\Result\Contracts\Result;

final readonly class CheckAction
{
    use AsAction;

    public function __construct(private ProfanityChecker $checker) {}

    /**
     * Check text for offensive content
     *
     * @param string $text The text to check
     * @param ContentType|null $contentType Optional content type for threshold adjustment
     * @param Audience|null $audience Optional audience type for threshold adjustment
     * @return Result The analysis result
     */
    public function handle(string $text, ?ContentType $contentType = null, ?Audience $audience = null): Result
    {
        return $this->checker->check($text, $contentType, $audience);
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
            contentType: $request->contentType(),
            audience: $request->audience(),
        );
        return new ResultResource($result);
    }
}
