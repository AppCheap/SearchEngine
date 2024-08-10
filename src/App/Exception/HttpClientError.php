<?php

namespace Appcheap\SearchEngine\App\Exception;

use Exception;

class HttpClientError extends Exception
{
    /**
     * @var int The HTTP status code.
     */
    private $statusCode;

    /**
     * @var string The error message.
     */
    private $errorMessage;

    /**
     * HttpClientError constructor.
     *
     * @param int $statusCode The HTTP status code.
     * @param string $errorMessage The error message.
     */
    public function __construct(int $statusCode, string $errorMessage)
    {
        $this->statusCode = $statusCode;
        $this->errorMessage = $errorMessage;
        parent::__construct($errorMessage, $statusCode);
    }

    /**
     * Get the HTTP status code.
     *
     * @return int The HTTP status code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get the error message.
     *
     * @return string The error message.
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
