<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Configuration options for a collector
 */
final class MongoLoggerCollector extends AbstractOptions
{
    /** @var string name to be assigned to the collector */
    protected string $name = 'odm_default';

    /** @var string|null service name of the configuration where the logger has to be put */
    protected string|null $configuration = null;

    /** @var string|null service name of the Logger to be used */
    protected string|null $mongoLogger = null;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Name of the collector
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setConfiguration(string|null $configuration): self
    {
        $this->configuration = $configuration ?: null;

        return $this;
    }

    /**
     * Configuration service name (where to set the logger)
     */
    public function getConfiguration(): string
    {
        return $this->configuration ?? 'doctrine.configuration.odm_default';
    }

    public function setMongoLogger(string|null $mongoLogger): self
    {
        $this->mongoLogger = $mongoLogger ?: null;

        return $this;
    }

    /**
     * Logger service name
     */
    public function getMongoLogger(): string|null
    {
        return $this->mongoLogger;
    }
}
