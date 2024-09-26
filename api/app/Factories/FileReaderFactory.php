<?php

namespace App\Factories;

use App\Contracts\FileReaderProviderFactory;
use App\FileReader\RssFileReader;

class FileReaderFactory implements FileReaderProviderFactory
{
    public static function create(string $extension): RssFileReader
    {
        return match ($extension) {
            'xml' => new RssFileReader(),
            default => throw new \InvalidArgumentException("Unknown file reader type: $extension"),
        };
    }
}
