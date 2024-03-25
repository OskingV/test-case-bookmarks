<?php

namespace App\Http\Resources\API\Bookmark;

use App\Helpers\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $modifiedFields = [
            'created_at' => $this->created_at->format('H:i d.m.Y'),
            'favicon_url' => $this->url . $this->favicon_path
        ];
        $unmodifiedFields = Arr::fillArrayByObject([
            'id',
            'url',
            'title'
        ], $this);

        return array_merge($modifiedFields, $unmodifiedFields);
    }
}
