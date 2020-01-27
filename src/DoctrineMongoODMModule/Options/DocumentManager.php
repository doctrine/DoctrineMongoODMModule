<?php
namespace DoctrineMongoODMModule\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Document manager options for doctrine mongo
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
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

    /**
     *
     * @param type $configuration
     * @return \DoctrineMongoODMModule\Options\DocumentManager
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = (string) $configuration;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfiguration()
    {
        return "doctrine.configuration.{$this->configuration}";
    }

    /**
     *
     * @param type $connection
     * @return \DoctrineMongoODMModule\Options\DocumentManager
     */
    public function setConnection($connection)
    {
        $this->connection = (string) $connection;
        return $this;
    }

    /**
     * @return string
     */
    public function getConnection()
    {
        return "doctrine.connection.{$this->connection}";
    }

    /**
     *
     * @return string
     */
    public function getEventManager()
    {
        return "doctrine.eventmanager.{$this->eventManager}";
    }

    /**
     *
     * @param type $eventManager
     * @return \DoctrineMongoODMModule\Options\DocumentManager
     */
    public function setEventManager($eventManager)
    {
        $this->eventManager = (string) $eventManager;
        return $this;
    }
}
