<?php

namespace Tests\Feature\API;

use App\Models\Bookmark;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    /**
     * Test store bookmark method
     *
     * @return void
     */
    public function testStore(): void
    {
        $storeBookmarkData = [
            'url' => 'https://www.google.com'
        ];
        $url = config('app.url') . '/api/bookmarks';
        $response = $this->json('POST', $url, $storeBookmarkData);
        $response->assertStatus(201);
        $storedBookmarkQuery = Bookmark::where([
            'url' => $storeBookmarkData['url']
        ]);
        $this->assertTrue($storedBookmarkQuery->exists());
        $storedBookmark = $storedBookmarkQuery->first();
        $response->assertJson([
            'data' => [
                'id' => $storedBookmark->id,
                'created_at' => $storedBookmark->created_at->format('H:i d.m.Y'),
                'favicon_url' => $storedBookmark->url . $storedBookmark->favicon_path,
                'url' => $storedBookmark->url,
                'title' => $storedBookmark->title,
                'meta_description' => $storedBookmark->meta_description,
                'meta_keywords' => $storedBookmark->meta_keywords
            ]
        ]);
    }
}
