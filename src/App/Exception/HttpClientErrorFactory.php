<?php

namespace Appcheap\SearchEngine\App\Exception;

/**
 * Class HttpClientErrorFactory
 *
 * A factory class for creating HTTP client error exceptions.
 */
class HttpClientErrorFactory
{
    /**
     * Create an HTTP client error exception based on the HTTP status code.
     *
     * @param int $statusCode The HTTP status code.
     * @param string|null $message The exception message.
     * @return HttpClientError
     */
    public static function createException(int $statusCode, string $message = null): HttpClientError
    {
        switch ($statusCode) {
            case 400:
                return new BadRequestException($message);
            case 401:
                return new UnauthorizedException($message);
            case 404:
                return new NotFoundException($message);
            case 409:
                return new ConflictException($message);
            case 422:
                return new UnprocessableEntityException($message);
            case 503:
                return new ServiceUnavailableException($message);
            default:
                return new HttpClientError($statusCode, $message ?? "Unknown error occurred.");
        }
    }
}
