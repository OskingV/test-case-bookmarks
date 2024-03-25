<?php

namespace App\Http\Controllers\API\Bookmark;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Bookmark\ItemResource;
use App\Services\Bookmark\BookmarkService;

class ShowController extends Controller
{
    /**
     * Return bookmark info by id.
     *
     * @param int $id
     * @param BookmarkService $service
     *
     * @return ItemResource
     */
    public function __invoke(int $id, BookmarkService $service): ItemResource
    {
        $bookmark = $service->getItem($id);

        return new ItemResource($bookmark);
    }
}
