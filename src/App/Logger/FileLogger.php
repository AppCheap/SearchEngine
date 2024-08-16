<?php

namespace Appcheap\SearchEngine\App\Logger;

use Exception;

/**
 * The logger file class.
 */
class FileLogger implements LoggerInterface
{
    /**
     * The logger instance.
     *
     * @var Logger
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param array $config The logger instance.
     */
    public function __construct(array $config)
    {
        if (! isset($config['logger'])) {
            throw new Exception('Logger type is not specified in the configuration.');
        }
        $this->logger = $config['logger'];
    }

    /**
     * Log the message.
     *
     * @param string $level   The log level.
     * @param string $message The log message.
     * @param array  $context The log context.
     * @return void
     */
    public function log(string $level, string $message, array $context = [])
    {
        $this->logger->log($level, $message, $context);
    }
}
