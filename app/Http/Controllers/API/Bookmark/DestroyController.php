<?php

namespace App\Http\Controllers\API\Bookmark;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Bookmark\DestroyRequest;
use App\Services\Bookmark\BookmarkService;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Destroy bookmark by id
     *
     * @param DestroyRequest $request
     * @param BookmarkService $service
     *
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, BookmarkService $service)
    {
        $service->deleteItem($request->id);

        return response()->json(['message' => 'ok'], 200);
    }
}
