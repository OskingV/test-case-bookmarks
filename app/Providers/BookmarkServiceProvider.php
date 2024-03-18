<?php

namespace App\Providers;

use App\Services\Site\Contracts\Parser;
use App\Services\Site\CrawlerParser;
use Illuminate\Support\ServiceProvider;

class BookmarkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(Parser::class, CrawlerParser::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
