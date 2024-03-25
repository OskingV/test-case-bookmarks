<?php

namespace App\Repositories;

use App\Models\Bookmark;
use App\Models\Bookmark as Model;
use Illuminate\Database\Eloquent\Collection;

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
     * @param array $sortConfig
     * @param string $searchString
     *
     * @return mixed
     */
    public function getList(array $sortConfig = [], string $searchString = ''): mixed
    {
        $query = $this->start();
        if ($searchString) {
            $query = $query->where('url', 'LIKE', '%' . $searchString . '%')
                ->orWhere('title', 'LIKE', '%' . $searchString . '%')
                ->orWhere('meta_description', 'LIKE', '%' . $searchString . '%')
                ->orWhere('meta_keywords', 'LIKE', '%' . $searchString . '%');
        }
        if (!empty($sortConfig)) {
            $query = $query->orderBy($sortConfig['field'], $sortConfig['type']);
        } else {
            $query = $query->orderBy('created_at', 'desc');
        }

        return $query
            ->paginate(3, [
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

    /**
     * Get collection for Excel file.
     *
     * @return Collection
     */
    public function getExcelList(): Collection
    {
        return $this->start()->orderBy('created_at', 'desc')
            ->get([
                'id',
                'favicon_path',
                'url',
                'title',
                'meta_description',
                'meta_keywords',
                'created_at'
            ]);
    }

    /**
     * Delete bookmark by id.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->model::destroy($id);
    }
}
