<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Logging;

use Doctrine\ODM\MongoDB\APM\CommandLoggerInterface;
use MongoDB\Driver\Monitoring\CommandFailedEvent;
use MongoDB\Driver\Monitoring\CommandStartedEvent;
use MongoDB\Driver\Monitoring\CommandSucceededEvent;

use function MongoDB\Driver\Monitoring\addSubscriber;
use function MongoDB\Driver\Monitoring\removeSubscriber;

/**
 * Includes executed queries in a Debug Stack
 *
 * @link    www.doctrine-project.org
 */
class DebugStack implements CommandLoggerInterface
{
    /** @var mixed[] $queries Executed queries. */
    public $queries = [];

    /** @var bool $enabled If Debug Stack is enabled (log queries) or not. */
    public $enabled = true;

    /** @var mixed $currentQuery */
    protected $currentQuery = 0;

    public function __construct()
    {
        $this->register();
    }

    public function register(): void
    {
        addSubscriber($this);
        $this->enabled = true;
    }

    public function unregister(): void
    {
        removeSubscriber($this);
        $this->enabled = false;
    }

    public function commandStarted(CommandStartedEvent $event): void
    {
        if (! $this->enabled) {
            return;
        }

        $this->queries[++$this->currentQuery] = [
            'command' => $event->getCommand(),
            'db' => $event->getDatabaseName(),
        ];
    }

    public function commandSucceeded(CommandSucceededEvent $event): void
    {
        // currently not being logged
    }

    public function commandFailed(CommandFailedEvent $event): void
    {
        // currently not being logged
    }
}
