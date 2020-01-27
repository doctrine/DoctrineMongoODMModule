<?php

namespace DoctrineMongoODMModule\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Configuration options for a collector
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 */
class MongoLoggerCollector extends AbstractOptions
{
    /**
     * @var string name to be assigned to the collector
     */
    protected $name = 'odm_default';

    /**
     * @var string|null service name of the configuration where the logger has to be put
     */
    protected $configuration;

    /**
     * @var string|null service name of the Logger to be used
     */
    protected $mongoLogger;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Name of the collector
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration ? (string) $configuration : null;
    }

    /**
     * Configuration service name (where to set the logger)
     *
     * @return string
     */
    public function getConfiguration()
    {
        return $this->configuration ? $this->configuration : 'doctrine.configuration.odm_default';
    }

    /**
     * @param string|null $mongoLogger
     */
    public function setMongoLogger($mongoLogger)
    {
        $this->mongoLogger = $mongoLogger ? (string) $mongoLogger : null;
    }

    /**
     * Logger service name
     *
     * @return string|null
     */
    public function getMongoLogger()
    {
        return $this->mongoLogger;
    }
}
