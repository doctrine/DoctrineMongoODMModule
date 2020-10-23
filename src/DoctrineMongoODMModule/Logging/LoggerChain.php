<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Logging;

use Doctrine\ODM\MongoDB\APM\CommandLoggerInterface;
use MongoDB\Driver\Monitoring\CommandFailedEvent;
use MongoDB\Driver\Monitoring\CommandStartedEvent;
use MongoDB\Driver\Monitoring\CommandSucceededEvent;

/**
 * Chains multiple Logger
 *
 * @link    www.doctrine-project.org
 */
class LoggerChain implements CommandLoggerInterface
{
    /** @var CommandLoggerInterface[] $loggers */
    private $loggers = [];

    /**
     * Adds a logger in the chain
     */
    public function addLogger(CommandLoggerInterface $logger) : void
    {
        $this->loggers[] = $logger;
        $logger->register();
    }

    public function register() : void
    {
        foreach ($this->loggers as $logger) {
            $logger->register();
        }
    }

    public function unregister() : void
    {
        foreach ($this->loggers as $logger) {
            $logger->unregister();
        }
    }

    public function commandFailed(CommandFailedEvent $event) : void
    {
        foreach ($this->loggers as $logger) {
            $logger->commandFailed($event);
        }
    }

    public function commandStarted(CommandStartedEvent $event) : void
    {
        foreach ($this->loggers as $logger) {
            $logger->commandStarted($event);
        }
    }

    public function commandSucceeded(CommandSucceededEvent $event) : void
    {
        foreach ($this->loggers as $logger) {
            $logger->commandSucceeded($event);
        }
    }
}
