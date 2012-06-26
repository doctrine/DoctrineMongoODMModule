<?php

namespace DoctrineMongoODMModule\Options;

use Zend\Stdlib\Options;

class Connection extends Options
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
     * Set the eventmanager key for the EventManager. EventManager key
     * is assembled as "doctrine.eventmanager.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $eventmanager = 'odm_default';


    /**
     * Set the wrapper class for the driver. In general, this shouldn't
     * need to be changed.
     *
     * @var string|null
     */
    protected $wrapperClass = null;

    /**
     * Mongo server hostname
     *
     * @var array
     */
    protected $server = null;

    /**
     * An array of options for the connection
     *
     * @var array
     */
    protected $options = array();

    /**
     * @param string $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return string
     */
    public function getConfiguration()
    {
        return "doctrine.configuration.{$this->configuration}";
    }

    /**
     * @param string $eventmanager
     */
    public function setEventmanager($eventmanager)
    {
        $this->eventmanager = $eventmanager;
    }

    /**
     * @return string
     */
    public function getEventmanager()
    {
        return "doctrine.eventmanager.{$this->eventmanager}";
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }

    /**
     * @return array
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param string $wrapperClass
     */
    public function setWrapperClass($wrapperClass)
    {
        $this->wrapperClass = $wrapperClass;
    }

    /**
     * @return string
     */
    public function getWrapperClass()
    {
        return $this->wrapperClass;
    }
}