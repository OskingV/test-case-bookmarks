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
}
