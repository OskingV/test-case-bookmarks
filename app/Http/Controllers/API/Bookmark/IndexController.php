<?php

namespace App\Http\Controllers\API\Bookmark;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Bookmark\ListResource;
use App\Services\Bookmark\BookmarkService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexController extends Controller
{
    /**
     * Return bookmarks list.
     *
     * @param BookmarkService $service
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(BookmarkService $service): AnonymousResourceCollection
    {
        $bookmarks = app()->call([$service, 'getList']);

        return ListResource::collection($bookmarks);
    }
}
