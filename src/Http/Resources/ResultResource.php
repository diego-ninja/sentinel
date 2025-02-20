<?php

namespace Ninja\Sentinel\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ninja\Sentinel\Enums\Category;
use Ninja\Sentinel\Result\Result;

/**
 * @property Result $resource
 *
 * @mixin Result
 */
class ResultResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'text' => [
                'original' => $this->resource->original(),
                'replaced' => $this->resource->replaced(),
            ],
            'offensive' => $this->resource->offensive(),
            'words' => $this->resource->words(),
            'score' => $this->resource->score()?->value(),
            'confidence' => $this->resource->confidence()?->value(),
            'categories' => array_map(fn(Category $category) => $category->value, $this->resource->categories()),
            'matches' => MatchResource::collection($this->resource->matches()),
        ];
    }
}
