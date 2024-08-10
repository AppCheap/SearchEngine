<?php

namespace Appcheap\SearchEngine\App\Exception;

/**
 * Class BadRequestException
 */
class BadRequestException extends HttpClientError
{
    public function __construct(string $errorMessage = "Bad Request")
    {
        parent::__construct(400, $errorMessage);
    }
}
