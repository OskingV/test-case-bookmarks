<?php

namespace Tests\Feature\API;

use App\Models\Bookmark;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

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

    /**
     * Test get bookmarks list method
     *
     * @return void
     *
     * @throws Exception
     */
    public function testIndex(): void
    {
        $bookmarks = Bookmark::factory()->count(random_int(1, 3))->create();
        $url = config('app.url') . '/api/bookmarks';
        $response = $this->json('GET', $url);
        $response->assertStatus(200);
        $array = [];
        foreach ($bookmarks as $bookmark) {
            $array[] = [
                'id' => $bookmark->id,
                'created_at' => $bookmark->created_at->format('H:i d.m.Y'),
                'favicon_url' => $bookmark->url . $bookmark->favicon_path,
                'url' => $bookmark->url,
                'title' => $bookmark->title
            ];
        }
        $response->assertJsonFragment([
            'data' => $array
        ]);
    }

    /**
     * Test get bookmark's info
     *
     * @return void
     */
    public function testShow(): void
    {
        $bookmark = Bookmark::factory()->create();
        $url = config('app.url') . '/api/bookmarks/' . $bookmark->id;
        $response = $this->json('GET', $url);
        $response->assertStatus(200);
        $resultArray = [
            'created_at' => $bookmark->created_at->format('H:i d.m.Y'),
            'favicon_url' => $bookmark->url . $bookmark->favicon_path,
            'id' => $bookmark->id,
            'meta_description' => $bookmark->meta_description,
            'meta_keywords' => $bookmark->meta_keywords,
            'url' => $bookmark->url,
            'title' => $bookmark->title,
        ];
        $response->assertJsonFragment([
            'data' => $resultArray
        ]);
    }
}
