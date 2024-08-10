<?php

namespace Appcheap\SearchEngine\App\Exception;

/**
 * Class UnprocessableEntityException
 */
class UnprocessableEntityException extends HttpClientError
{
    public function __construct(string $errorMessage = "Unprocessable Entity - Request is well-formed, but cannot be processed.")
    {
        parent::__construct(422, $errorMessage);
    }
}
