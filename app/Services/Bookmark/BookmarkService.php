<?php

namespace App\Services\Bookmark;

use App\Http\Requests\API\Bookmark\IndexRequest;
use App\Http\Requests\API\Bookmark\StoreRequest;
use App\Models\Bookmark;
use App\Repositories\BookmarkRepository;
use App\Services\Site\Contracts\Parser;

class BookmarkService
{
    /**
     * Bookmark repository.
     *
     * @var BookmarkRepository
     */
    private BookmarkRepository $repository;

    /**
     * Create a new CRUD service instance.
     *
     * @param BookmarkRepository $repository
     */
    public function __construct(BookmarkRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store new bookmark.
     *
     * @param StoreRequest $request
     * @param Parser $parser
     *
     * @return Bookmark
     */
    public function store(StoreRequest $request, Parser $parser): Bookmark
    {
        $url = $request->url;
        $parsedData = $parser->parse($url);
        $parsedData['url'] = $url;

        return $this->repository->store($parsedData);
    }

    /**
     * Get bookmarks list with pagination.
     *
     * @param IndexRequest $request
     *
     * @return mixed
     */
    public function getList(IndexRequest $request): mixed
    {
        $sortConfig = $request->exists('sort_field') ? [
            'field' => $request->sort_field,
            'type' => $request->sort_type
        ] : [];

        return $this->repository->getList($sortConfig);
    }

    /**
     * Get bookmark by id.
     *
     * @param int $id
     *
     * @return Bookmark
     */
    public function getItem(int $id): Bookmark
    {
        return $this->repository->getItem($id);
    }
}
