<?php
namespace DoctrineMongoODMModule\Logging;

/**
 * Chains multiple Logger
 *
 * @license MIT
 * @link    www.doctrine-project.org
 */
class LoggerChain implements Logger
{
    private $loggers = [];

    /**
     * Adds a logger in the chain
     *
     * @param Logger $logger
     */
    public function addLogger(Logger $logger)
    {
        $this->loggers[] = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function log(array $logs)
    {
        foreach ($this->loggers as $logger) {
            $logger->log($logs);
        }
    }
}
