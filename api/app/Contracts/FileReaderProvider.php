<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface FileReaderProvider
{
    public function read(string $url, array $queryParams = []): Collection;
}
