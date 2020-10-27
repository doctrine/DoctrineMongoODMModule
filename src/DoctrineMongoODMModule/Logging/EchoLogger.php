<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Logging;

use Doctrine\ODM\MongoDB\APM\CommandLoggerInterface;
use MongoDB\Driver\Monitoring\CommandFailedEvent;
use MongoDB\Driver\Monitoring\CommandStartedEvent;
use MongoDB\Driver\Monitoring\CommandSucceededEvent;
use Symfony\Component\VarDumper\VarDumper;

use function MongoDB\Driver\Monitoring\addSubscriber;
use function MongoDB\Driver\Monitoring\removeSubscriber;

/**
 * A logger that logs to the standard output using echo/var_dump.
 *
 * @link    www.doctrine-project.org
 */
class EchoLogger implements CommandLoggerInterface
{
    public function __construct()
    {
        $this->register();
    }

    public function register() : void
    {
        addSubscriber($this);
    }

    public function unregister() : void
    {
        removeSubscriber($this);
    }

    public function commandFailed(CommandFailedEvent $event)
    {
        echo $event->getError()->getTraceAsString();
    }

    public function commandStarted(CommandStartedEvent $event)
    {
        VarDumper::dump(
            [
                'command' => $event->getCommand(),
                'db'      => $event->getDatabaseName(),
            ]
        );
    }

    public function commandSucceeded(CommandSucceededEvent $event)
    {
        echo sprintf("%s\n%s", $event->getRequestId(), $event->getCommandName());
    }
}
