<?php

namespace Tests\Unit\Services\Bookmark;

use App\Http\Requests\API\Bookmark\StoreRequest;
use App\Services\Bookmark\BookmarkService;
use App\Services\Site\Contracts\Parser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class BookmarkServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test store bookmark method.
     *
     * @return void
     */
    public function testStore(): void
    {
        $service = app(BookmarkService::class);
        $url = $this->faker->url;
        $bookmarkData = [
            'favicon_path' => '/favicon.ico',
            'title' => $this->faker->title,
            'meta_description' => $this->faker->sentence,
            'meta_keywords' => $this->faker->sentence
        ];
        $this->instance(
            Parser::class,
            Mockery::mock(Parser::class, function (MockInterface $mock) use ($url, $bookmarkData) {
                $mock->shouldReceive('parse')->with($url)->andReturn($bookmarkData)->once();
            })
        );
        $storeRequestMock = $this->getMockBuilder(StoreRequest::class)
            ->onlyMethods(['only'])
            ->getMock();
        $storeRequestMock->expects($this->once())
            ->method('only')
            ->with(['url', 'password'])
            ->willReturn(['url' => $url]);
        $storeRequestMock->url = $url;
        $this->instance(StoreRequest::class, $storeRequestMock);
        $bookmark = app()->call([$service, 'store']);
        $bookmarkData['url'] = $url;
        foreach ($bookmarkData as $key => $item) {
            $this->assertTrue($bookmark->$key === $item);
        }
    }
}
