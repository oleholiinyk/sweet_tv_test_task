<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileReaderException extends HttpException
{
    public function __construct($message = 'Failed to fetch the URL')
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message);
    }
}
