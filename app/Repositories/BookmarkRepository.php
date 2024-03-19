<?php

namespace App\Repositories;

use App\Models\Bookmark;
use App\Models\Bookmark as Model;

class BookmarkRepository extends BaseRepository
{
    /**
     * Get model class.
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Store bookmark to DB.
     *
     * @param array $data
     *
     * @return Model
     */
    public function store(array $data): Bookmark
    {
        return $this->start()->create($data);
    }

    /**
     * Get bookmarks list with pagination.
     *
     * @return mixed
     */
    public function getList(): mixed
    {
        return $this->start()->paginate(3, [
            'id',
            'favicon_path',
            'url',
            'title',
            'created_at'
        ]);
    }

    /**
     * Get bookmark item by id.
     *
     * @param int $id
     *
     * @return Bookmark
     */
    public function getItem(int $id): Bookmark
    {
        return $this->start()->findOrFail($id, [
            'id',
            'favicon_path',
            'url',
            'title',
            'meta_description',
            'meta_keywords',
            'created_at',
        ]);
    }
}
