<?php

namespace Appcheap\SearchEngine\App\Exception;

/**
 * Class BadRequestException
 */
class BadRequestException extends HttpClientError
{
    public function __construct(string $errorMessage = "Bad Request - The request could not be understood due to malformed syntax.")
    {
        parent::__construct(400, $errorMessage);
    }
}
