<?php

namespace App\Http\Controllers\API\Bookmark;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Bookmark\ItemResource;
use App\Services\Bookmark\BookmarkService;

class StoreController extends Controller
{
    /**
     * Store bookmark and return json response with bookmark info.
     *
     * @param BookmarkService $service
     *
     * @return ItemResource
     */
    public function __invoke(BookmarkService $service): ItemResource
    {
        $bookmark = app()->call([$service, 'store']);

        return new ItemResource($bookmark);
    }
}
