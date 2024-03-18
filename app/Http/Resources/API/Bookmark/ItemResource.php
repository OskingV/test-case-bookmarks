<?php

namespace App\Http\Resources\API\Bookmark;

use App\Helpers\Arr;
use Illuminate\Http\Request;

class ItemResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $unmodifiedFields = Arr::fillArrayByObject([
            'meta_description',
            'meta_keywords'
        ], $this);

        return array_merge(parent::toArray($request), $unmodifiedFields);
    }
}
