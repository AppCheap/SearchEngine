<?php

namespace Appcheap\SearchEngine\App\Exception;

/**
 * Class ConflictException
 */
class ConflictException extends HttpClientError
{
    public function __construct(string $errorMessage = "Conflict - When a resource already exists.") {
        parent::__construct(409, $errorMessage);
    }
}

