<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Configuration options for a collector
 *
 * @link    http://www.doctrine-project.org/
 */
class MongoLoggerCollector extends AbstractOptions
{
    /** @var string name to be assigned to the collector */
    protected $name = 'odm_default';

    /** @var string|null service name of the configuration where the logger has to be put */
    protected $configuration;

    /** @var string|null service name of the Logger to be used */
    protected $mongoLogger;

    public function setName(string $name) : void
    {
        $this->name = (string) $name;
    }

    /**
     * Name of the collector
     */
    public function getName() : string
    {
        return $this->name;
    }

    public function setConfiguration(?string $configuration) : void
    {
        $this->configuration = $configuration ? (string) $configuration : null;
    }

    /**
     * Configuration service name (where to set the logger)
     */
    public function getConfiguration() : string
    {
        return $this->configuration ? $this->configuration : 'doctrine.configuration.odm_default';
    }

    public function setMongoLogger(?string $mongoLogger) : void
    {
        $this->mongoLogger = $mongoLogger ? (string) $mongoLogger : null;
    }

    /**
     * Logger service name
     */
    public function getMongoLogger() : ?string
    {
        return $this->mongoLogger;
    }
}
