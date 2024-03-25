<?php

namespace App\Observers;

use App\Models\Bookmark;
use Illuminate\Support\Facades\Hash;

class BookmarkObserver
{
    /**
     * Hash password field before saving bookmark info to db.
     *
     * @param Bookmark $bookmark
     * @return void
     */
    public function creating(Bookmark $bookmark): void
    {
        if (isset($bookmark->password) || $bookmark->password  !== '') {
            $bookmark->password = Hash::make($bookmark->password);
        }
    }
}
