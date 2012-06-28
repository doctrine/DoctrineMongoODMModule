<?php

namespace DoctrineMongoODMModule\Options;

use Zend\Stdlib\Options;

class Configuration extends Options
{

    /**
     * Set the cache key for the metadata cache. Cache key
     * is assembled as "doctrine.cache.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $metadataCache = 'array';

    /**
     * Automatic generation of proxies (disable for production!)
     *
     * @var bool
     */
    protected $generateProxies = true;

    /**
     * Proxy directory.
     *
     * @var string
     */
    protected $proxyDir = 'data';

    /**
     * Proxy namespace.
     *
     * @var string
     */
    protected $proxyNamespace = 'DoctrineMongoODMModule\Proxy';

    /**
     * Automatic generation of hydrators (disable for production!)
     *
     * @var boolean
     */
    protected $generateHydrators = true;

    /**
     * Hydrator directory
     *
     * @var string
     */
    protected $hydratorDir = 'data';

    /**
     * Hydrator namespace
     *
     * @var string
     */
    protected $hydratorNamespace = 'DoctrineMongoODMModule\Hydrator';

    /**
     *
     * @var string
     */
    protected $driver;

    /**
     *
     * @var boolean
     */
    protected $autoloadAnnotations = true;

    /**
     *
     * @var string
     */
    protected $defaultDb;

    /**
     *
     * @param string $driver
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setDriver($driver)
    {
        $this->driver = (string) $driver;
        return $this;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return "doctrine.driver.{$this->driver}";
    }

    /**
     *
     * @param boolean $generateProxies
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setGenerateProxies($generateProxies)
    {
        $this->generateProxies = (boolean) $generateProxies;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getGenerateProxies()
    {
        return $this->generateProxies;
    }

    /**
     *
     * @param string $metadataCache
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setMetadataCache($metadataCache)
    {
        $this->metadataCache = (string) $metadataCache;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetadataCache()
    {
        return "doctrine.cache.{$this->metadataCache}";
    }

    /**
     *
     * @param string $proxyDir
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setProxyDir($proxyDir)
    {
        $this->proxyDir = (string) $proxyDir;
        return $this;
    }

    /**
     * @return string
     */
    public function getProxyDir()
    {
        return $this->proxyDir;
    }

    /**
     *
     * @param string $proxyNamespace
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setProxyNamespace($proxyNamespace)
    {
        $this->proxyNamespace = (string) $proxyNamespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getProxyNamespace()
    {
        return $this->proxyNamespace;
    }

    /**
     *
     * @return boolean
     */
    public function getGenerateHydrators() {
        return $this->generateHydrators;
    }

    /**
     *
     * @param boolean $generateHydrators
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setGenerateHydrators($generateHydrators) {
        $this->generateHydrators = (boolean) $generateHydrators;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getHydratorDir() {
        return $this->hydratorDir;
    }

    /**
     *
     * @param string $hydratorDir
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setHydratorDir($hydratorDir) {
        $this->hydratorDir = (string) $hydratorDir;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getHydratorNamespace() {
        return $this->hydratorNamespace;
    }

    /**
     *
     * @param string $hydratorNamespace
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setHydratorNamespace($hydratorNamespace) {
        $this->hydratorNamespace = (string) $hydratorNamespace;
        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function getAutoloadAnnotations() {
        return $this->autoloadAnnotations;
    }

    /**
     *
     * @param boolean $autoloadAnnotations
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setAutoloadAnnotations($autoloadAnnotations) {
        $this->autoloadAnnotations = (boolean) $autoloadAnnotations;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDefaultDb() {
        return $this->defaultDb;
    }

    /**
     *
     * @param string $defaultDb
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setDefaultDb($defaultDb) {
        $this->defaultDb = (string) $defaultDb;
        return $this;
    }
}