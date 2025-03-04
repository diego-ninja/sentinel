<?php

namespace Ninja\Sentinel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Ninja\Sentinel\ValueObject\Coincidence;

/**
 * @property Coincidence $resource
 *
 * @mixin Coincidence
 */
class MatchResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'match' => $this->resource->word(),
            'type' => $this->resource->type(),
            'score' => $this->resource->score()->value(),
            'confidence' => $this->resource->confidence()->value(),
            'language' => $this->resource->context(),
        ];
    }
}
