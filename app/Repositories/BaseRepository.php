<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * Model instance.
     *
     * @var Model
     */
    protected $model;

    /**
     * Create base repository instance.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * Get model class.
     *
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * Clone model property before get data.
     *
     * @return \Illuminate\Contracts\Foundation\Application|Model|\Illuminate\Foundation\Application|mixed
     */
    protected function start(): Model
    {
        return clone $this->model;
    }
}
