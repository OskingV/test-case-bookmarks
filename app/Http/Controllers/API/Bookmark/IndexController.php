<?php

namespace App\Http\Controllers\API\Bookmark;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Bookmark\IndexRequest;
use App\Http\Resources\API\Bookmark\ListResource;
use App\Models\Bookmark;
use App\Services\Bookmark\BookmarkService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexController extends Controller
{
    /**
     * Return bookmarks list.
     *
     * @param IndexRequest $request
     * @param BookmarkService $service
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(IndexRequest $request, BookmarkService $service): AnonymousResourceCollection
    {
        $bookmarks = $service->getList($request);

        return ListResource::collection($bookmarks);
    }
}
