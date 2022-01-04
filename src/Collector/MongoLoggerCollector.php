<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Collector;

use DoctrineMongoODMModule\Logging\DebugStack;
use Laminas\DeveloperTools\Collector\AutoHideInterface;
use Laminas\DeveloperTools\Collector\CollectorInterface;
use Laminas\Mvc\MvcEvent;

use function count;

/**
 * Collector to be used in Laminas\DeveloperTools to record and display Mongo
 * queries
 *
 * @link    www.doctrine-project.org
 */
class MongoLoggerCollector implements CollectorInterface, AutoHideInterface
{
    /**
     * Collector priority
     */
    public const PRIORITY = 10;

    protected DebugStack $mongoLogger;

    protected string $name;

    public function __construct(DebugStack $mongoLogger, string $name)
    {
        $this->mongoLogger = $mongoLogger;
        $this->name        = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriority(): int
    {
        return self::PRIORITY;
    }

    public function collect(MvcEvent $mvcEvent): void
    {
    }

    public function canHide(): bool
    {
        return empty($this->mongoLogger->queries);
    }

    public function getQueryCount(): int
    {
        return count($this->mongoLogger->queries);
    }

    /**
     * @return mixed[]
     */
    public function getQueries(): array
    {
        return $this->mongoLogger->queries;
    }

    public function getQueryTime(): float
    {
        return 0.0;
    }
}
