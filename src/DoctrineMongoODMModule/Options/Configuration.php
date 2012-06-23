<?php

namespace DoctrineMongoODMModule\Options;

use DoctrineModule\Options\Configuration as DoctrineConfiguration;

class Configuration extends DoctrineConfiguration
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
     * Set the cache key for the query cache. Cache key
     * is assembled as "doctrine.cache.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $queryCache = 'array';

    /**
     * Set the driver key for the metadata driver. Driver key
     * is assembeled as "doctrine.driver.{key}" and pulled from
     * service locator.
     *
     * @var string
     */
    protected $driver = 'array';

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
     * Proxy directory.
     *
     * @var string
     */
    protected $hydratorDir = 'data';

    /**
     * Proxy namespace.
     *
     * @var string
     */
    protected $hydratorNamespace = 'DoctrineMongoODMModule\Hydrator';




    /**
     * Entity alias map.
     *
     * @var array
     */
    protected $documentNamespaces = array();

    /**
     * @param array $datetimeFunctions
     */
    public function setDatetimeFunctions($datetimeFunctions)
    {
        $this->datetimeFunctions = $datetimeFunctions;
        return $this;
    }

    /**
     * @return array
     */
    public function getDatetimeFunctions()
    {
        return $this->datetimeFunctions;
    }

    /**
     * @param string $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
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
     * @param array $DocumentNamespaces
     */
    public function setDocumentNamespaces($DocumentNamespaces)
    {
        $this->DocumentNamespaces = $DocumentNamespaces;
        return $this;
    }

    /**
     * @return array
     */
    public function getDocumentNamespaces()
    {
        return $this->DocumentNamespaces;
    }

    /**
     * @param boolean $generateProxies
     */
    public function setGenerateProxies($generateProxies)
    {
        $this->generateProxies = $generateProxies;
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
     * @param string $metadataCache
     */
    public function setMetadataCache($metadataCache)
    {
        $this->metadataCache = $metadataCache;
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
     * @param string $proxyDir
     */
    public function setProxyDir($proxyDir)
    {
        $this->proxyDir = $proxyDir;
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
     * @param string $proxyNamespace
     */
    public function setProxyNamespace($proxyNamespace)
    {
        $this->proxyNamespace = $proxyNamespace;
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
     * @param string $hydratorDir
     */
    public function setHydratorDir($hydratorDir)
    {
        $this->hydratorDir = $hydratorDir;
        return $this;
    }

    /**
     * @return string
     */
    public function getHydratorDir()
    {
        return $this->hydratorDir;
    }

    /**
     * @param string $hydratorNamespace
     */
    public function setHydratorNamespace($hydratorNamespace)
    {
        $this->hydratorNamespace = $hydratorNamespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getHydratorNamespace()
    {
        return $this->hydratorNamespace;
    }
}