<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds for bookmark.
     *
     * @return void
     */
    public function run(): void
    {
        Bookmark::factory()
            ->count(100000)
            ->create();
    }
}
