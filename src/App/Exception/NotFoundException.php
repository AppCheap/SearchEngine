<?php

namespace Appcheap\SearchEngine\App\Exception;

/**
 * Class NotFoundException
 */
class NotFoundException extends HttpClientError
{
    public function __construct(string $errorMessage = "Not Found - The requested resource is not found.")
    {
        parent::__construct(404, $errorMessage);
    }
}
