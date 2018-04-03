<?php
namespace DoctrineMongoODMModule\Collector;

use ZendDeveloperTools\Collector\CollectorInterface;
use ZendDeveloperTools\Collector\AutoHideInterface;

use Zend\Mvc\MvcEvent;

use DoctrineMongoODMModule\Logging\DebugStack;

/**
 * Collector to be used in ZendDeveloperTools to record and display Mongo
 * queries
 *
 * @license MIT
 * @link    www.doctrine-project.org
 */
class MongoLoggerCollector implements CollectorInterface, AutoHideInterface
{
    /**
     * Collector priority
     */
    const PRIORITY = 10;

    /**
     * @var DebugStack
     */
    protected $mongoLogger;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param DebugStack $mongoLogger
     * @param string     $name
     */
    public function __construct(DebugStack $mongoLogger, $name)
    {
        $this->mongoLogger = $mongoLogger;
        $this->name = (string) $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return static::PRIORITY;
    }

    /**
     * {@inheritDoc}
     */
    public function collect(MvcEvent $mvcEvent)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function canHide()
    {
        return empty($this->mongoLogger->queries);
    }

    /**
     * @return int
     */
    public function getQueryCount()
    {
        return count($this->mongoLogger->queries);
    }

    /**
     * @return array
     */
    public function getQueries()
    {
        return $this->mongoLogger->queries;
    }

    /**
     * @return float
     */
    public function getQueryTime()
    {
        return 0.0;
    }
}
