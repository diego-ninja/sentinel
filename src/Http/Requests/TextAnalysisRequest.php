<?php

namespace Ninja\Sentinel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Ninja\Sentinel\Enums\Audience;
use Ninja\Sentinel\Enums\ContentType;

final class TextAnalysisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return array<string, array<int, Enum|string>|string>
     */
    public function rules(): array
    {
        return [
            'text' => 'required|string',
            'content_type' => ['nullable','string', Rule::enum(ContentType::class)],
            'audience' => ['nullable','string', Rule::enum(Audience::class)],
        ];
    }

    public function text(): string
    {
        $validated = parent::validated();

        /** @var string $text */
        $text = $validated['text'];
        return $text;
    }

    public function contentType(): ContentType
    {
        $validated = parent::validated();

        if (isset($validated['content_type'])) {
            /** @var string $contentType */
            $contentType = $validated['content_type'];
            return ContentType::from($contentType);
        }

        /** @var string $defaultContentType */
        $defaultContentType = config('sentinel.default_content_type', ContentType::SocialMedia);
        return ContentType::from($defaultContentType);
    }

    public function audience(): Audience
    {
        $validated = parent::validated();

        if (isset($validated['audience'])) {
            /** @var string $audience */
            $audience = $validated['audience'];
            return Audience::from($audience);
        }

        /** @var string $defaultAudience */
        $defaultAudience = config('sentinel.default_audience', Audience::Adult);
        return Audience::from($defaultAudience);
    }

}
