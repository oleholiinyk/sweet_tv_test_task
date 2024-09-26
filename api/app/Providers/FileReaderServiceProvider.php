<?php

namespace App\Providers;

use App\Contracts\FileReaderProvider;
use App\FileReader\RssFileReader;
use Illuminate\Support\ServiceProvider;

class FileReaderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(FileReaderProvider::class, RssFileReader::class);
    }
}
