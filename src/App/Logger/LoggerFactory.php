<?php

namespace Appcheap\SearchEngine\App\Logger;

use Exception;

/**
 * The logger factory class.
 */
class LoggerFactory
{
    /**
     * Create a logger instance based on the provided configuration.
     *
     * @param array $config The configuration array.
     * @return LoggerInterface
     * @throws Exception If the logger type is not supported.
     */
    public static function createLogger(array $config)
    {
        if (!isset($config['type'])) {
            throw new Exception('Logger type is not specified in the configuration.');
        }

        switch ($config['type']) {
            case 'file':
                return new FileLogger($config);
            // Add more cases here for different logger types
            default:
                throw new Exception('Unsupported logger type: ' . $config['type']);
        }
    }
}
