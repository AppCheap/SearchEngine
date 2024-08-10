<?php

namespace Appcheap\SearchEngine\App\Exception;

/**
 * Class ServiceUnavailableException
 */
class ServiceUnavailableException extends HttpClientError
{
    public function __construct(string $errorMessage = "Service Unavailable - We’re temporarily offline. Please try again later.")
    {
        parent::__construct(503, $errorMessage);
    }
}
