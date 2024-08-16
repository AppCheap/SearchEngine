<?php

namespace Appcheap\SearchEngine\App\Logger;

/**
 * The logger interface.
 */
interface LoggerInterface
{
    /**
     * Log the message.
     *
     * @param string $level   The log level.
     * @param string $message The log message.
     * @param array  $context The log context.
     * @return void
     */
    public function log(string $level, string $message, array $context = []);
}
