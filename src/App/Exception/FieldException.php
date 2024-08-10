<?php

namespace Appcheap\SearchEngine\App\Exception;

use Exception;

/**
 * Represents an exception that is thrown when there is an issue with a field.
 *
 */
class FieldException extends Exception
{
    /**
     * Constructs a new FieldException with the given message.
     *
     * @param string $message The exception message.
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
