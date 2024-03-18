<?php

namespace App\Http\Resources\API\Bookmark;

use Illuminate\Http\Request;

class ListResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
