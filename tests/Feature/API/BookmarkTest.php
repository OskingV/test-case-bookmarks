<?php

namespace Tests\Feature\API;

use App\Exports\BookmarksExport;
use App\Models\Bookmark;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;

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
        $password = 'pass';
        $storeBookmarkData = [
            'url' => 'https://www.google.com',
            'password' => $password
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
        $this->assertTrue(Hash::check($password, $storedBookmark->password));
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

    /**
     * Test sort bookmarks list
     *
     * @return void
     *
     * @throws Exception
     */
    public function testIndexSort(): void
    {
        $bookmarks = Bookmark::factory()->count(3)->create();
        $url = config('app.url') . '/api/bookmarks?sort_field=title&sort_type=asc';
        $response = $this->json('GET', $url);
        $response->assertStatus(200);
        $array = [];
        foreach ($bookmarks as $bookmark) {
            $array[$bookmark->id] = $bookmark->title;
        }
        asort($array);
        $resArray = [];
        $resultData = json_decode($response->content())->data;
        foreach ($resultData as $bookmark) {
            $resArray[$bookmark->id] = $bookmark->title;
        }
        $this->assertEquals(json_encode($array), json_encode($resArray));
    }

    /**
     * Test download excel
     *
     * @return void
     */
    public function testDownloadExcel(): void
    {
        $bookmark = Bookmark::factory()->create();
        Excel::fake();
        $this->get('/api/bookmarks/excel');
        Excel::assertDownloaded('bookmarks.xlsx', function (BookmarksExport $export) use ($bookmark) {
            return $export->collection()->contains($bookmark->id);
        });
    }

    /**
     * Test destroy
     *
     * @return void
     */
    public function testDestroy(): void
    {
        $password = '12345678';
        $deleteBookmarkData = [
            'password' => $password
        ];
        $bookmark = Bookmark::factory()->create(['password' => $password]);
        $url = config('app.url') . '/api/bookmarks/' . $bookmark->id;
        $response = $this->json('DELETE', $url, $deleteBookmarkData);
        $response->assertStatus(200);
        $this->assertNull(Bookmark::find($bookmark->id));
    }

    /**
     * Test destroy
     *
     * @return void
     */
    public function testFailDestroy(): void
    {
        $password = '12345678';
        $bookmark = Bookmark::factory()->create(['password' => $password]);
        $url = config('app.url') . '/api/bookmarks/' . $bookmark->id;
        $response = $this->json('DELETE', $url);
        $response->assertStatus(403);
        $this->assertNotNull(Bookmark::find($bookmark->id));
    }
}
