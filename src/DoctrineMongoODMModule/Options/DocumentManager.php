<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Document manager options for doctrine mongo
 *
 * @link    http://www.doctrine-project.org/
 */
class DocumentManager extends AbstractOptions
{
    /**
     * Set the configuration key for the Configuration. Configuration key
     * is assembled as "doctrine.configuration.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $configuration = 'odm_default';

    /**
     * Set the connection key for the Connection. Connection key
     * is assembled as "doctrine.connection.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $connection = 'odm_default';

    /**
     * Set the event manager key for the event manager. Key
     * is assembled as "doctrine.eventManager.{key} and pulled from
     * service locator.
     *
     * @var string
     */
    protected $eventManager = 'odm_default';

    public function setConfiguration(type $configuration) : DocumentManager
    {
        $this->configuration = (string) $configuration;

        return $this;
    }

    public function getConfiguration() : string
    {
        return 'doctrine.configuration.' . $this->configuration;
    }

    public function setConnection(type $connection) : DocumentManager
    {
        $this->connection = (string) $connection;

        return $this;
    }

    public function getConnection() : string
    {
        return 'doctrine.connection.' . $this->connection;
    }

    public function getEventManager() : string
    {
        return 'doctrine.eventmanager.' . $this->eventManager;
    }

    public function setEventManager(type $eventManager) : DocumentManager
    {
        $this->eventManager = (string) $eventManager;

        return $this;
    }
}
