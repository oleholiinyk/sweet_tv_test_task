<?php

namespace App\Contracts;

interface FileReaderProvider
{
    public function read(string $url, array $queryParams = []);
}
