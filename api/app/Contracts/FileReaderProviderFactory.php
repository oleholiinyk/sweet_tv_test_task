<?php

namespace App\Contracts;

interface FileReaderProviderFactory
{
    public static function create(string $extension);
}

