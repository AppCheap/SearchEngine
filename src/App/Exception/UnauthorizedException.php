<?php

namespace Appcheap\SearchEngine\App\Exception;

/**
 * Class UnauthorizedException
 */
class UnauthorizedException extends HttpClientError
{
    public function __construct(string $errorMessage = "Unauthorized - Your API key is wrong.") {
        parent::__construct(401, $errorMessage);
    }
}