<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Logging;

/**
 * Chains multiple Logger
 *
 * @link    www.doctrine-project.org
 */
class LoggerChain implements Logger
{
    /** @var mixed[] $loggers */
    private $loggers = [];

    /**
     * Adds a logger in the chain
     */
    public function addLogger(Logger $logger) : void
    {
        $this->loggers[] = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function log(array $logs) : void
    {
        foreach ($this->loggers as $logger) {
            $logger->log($logs);
        }
    }
}
