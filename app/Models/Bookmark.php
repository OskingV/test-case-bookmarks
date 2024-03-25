<?php

namespace App\Models;

use App\Observers\BookmarkObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([BookmarkObserver::class])]
class Bookmark extends Model
{
    use HasFactory;

    /**
     * The database name.
     *
     * @var string
     */
    protected $table = 'bookmarks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'favicon_path',
        'url',
        'title',
        'meta_description',
        'meta_keywords',
        'password',
    ];
}
