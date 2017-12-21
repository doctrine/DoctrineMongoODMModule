<?php
namespace DoctrineMongoODMModule\Options;

use Doctrine\Common\Proxy\AbstractProxyFactory;
use Zend\Stdlib\AbstractOptions;

/**
 * Configuration options for doctrine mongo
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Configuration extends AbstractOptions
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
    protected $generateProxies = AbstractProxyFactory::AUTOGENERATE_ALWAYS;

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
     * Persistent collection generation strategy.
     *
     * @var int
     */
    protected $generatePersistentCollections = \Doctrine\ODM\MongoDB\Configuration::AUTOGENERATE_ALWAYS;

    /**
     * Persistent collection directory.
     *
     * @var string
     */
    protected $persistentCollectionDir = 'data';

    /**
     * Persistent collection namespace.
     *
     * @var string
     */
    protected $persistentCollectionNamespace = 'DoctrineMongoODMModule\PersistentCollection';

    /**
     * Persistent collection factory service name.
     *
     * @var string
     */
    protected $persistentCollectionFactory;

    /**
     * Persistent collection generator service name.
     *
     * @var string
     */
    protected $persistentCollectionGenerator;

    /**
     *
     * @var string
     */
    protected $driver;

    /**
     *
     * @var string
     */
    protected $defaultDb;

    /**
     * An array of filters. Array should be in the form
     * array('filterName' => 'BSON\Filter\Class')
     *
     * @var array
     */
    protected $filters = [];

    /**
     *
     * @var \DoctrineMongoODMModule\Logging\Logger
     */
    protected $logger;

    /**
     *
     * @var string
     */
    protected $classMetadataFactoryName;

    /**
     *
     * @var string
     */
    protected $repositoryFactory;

    /**
     * Number of times to attempt to connect if an exception is encountered
     *
     * @var int
     */
    protected $retryConnect = 0;

    /**
     * Number of times to attempt a query if an exception is encountered
     *
     * @var int
     */
    protected $retryQuery = 0;

    /**
     * Keys must be the name of the type identifier and value is
     * the class name of the Type
     *
     * @var array
     */
    protected $types = [];

    /**
     *
     * @param string $driver
     * @return $this
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
     * @param int $generateProxies
     * @return $this
     */
    public function setGenerateProxies($generateProxies)
    {
        if (is_bool($generateProxies)) {
            $generateProxies = $generateProxies ? AbstractProxyFactory::AUTOGENERATE_ALWAYS : AbstractProxyFactory::AUTOGENERATE_NEVER;
        }

        $this->generateProxies = $generateProxies;
        return $this;
    }

    /**
     * @return int
     */
    public function getGenerateProxies()
    {
        return $this->generateProxies;
    }

    /**
     *
     * @param string $metadataCache
     * @return $this
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
     * @return $this
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
     * @return $this
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
    public function getGenerateHydrators()
    {
        return $this->generateHydrators;
    }

    /**
     *
     * @param boolean|int $generateHydrators
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setGenerateHydrators($generateHydrators)
    {
        $this->generateHydrators = $generateHydrators;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getHydratorDir()
    {
        return $this->hydratorDir;
    }

    /**
     *
     * @param string $hydratorDir
     * @return $this
     */
    public function setHydratorDir($hydratorDir)
    {
        $this->hydratorDir = (string) $hydratorDir;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getHydratorNamespace()
    {
        return $this->hydratorNamespace;
    }

    /**
     *
     * @param string $hydratorNamespace
     * @return $this
     */
    public function setHydratorNamespace($hydratorNamespace)
    {
        $this->hydratorNamespace = (string) $hydratorNamespace;
        return $this;
    }

    /**
     * @return int
     */
    public function getGeneratePersistentCollections()
    {
        return $this->generatePersistentCollections;
    }

    /**
     * @param int $generatePersistentCollections
     *
     * @return $this
     */
    public function setGeneratePersistentCollections($generatePersistentCollections)
    {
        $this->generatePersistentCollections = (int)$generatePersistentCollections;

        return $this;
    }

    /**
     * @return string
     */
    public function getPersistentCollectionDir()
    {
        return $this->persistentCollectionDir;
    }

    /**
     * @param string $persistentCollectionDir
     *
     * @return $this
     */
    public function setPersistentCollectionDir($persistentCollectionDir)
    {
        $this->persistentCollectionDir = (string)$persistentCollectionDir;

        return $this;
    }

    /**
     * @return string
     */
    public function getPersistentCollectionNamespace()
    {
        return $this->persistentCollectionNamespace;
    }

    /**
     * @param string $persistentCollectionNamespace
     *
     * @return $this
     */
    public function setPersistentCollectionNamespace($persistentCollectionNamespace)
    {
        $this->persistentCollectionNamespace = (string)$persistentCollectionNamespace;

        return $this;
    }

    /**
     * @return string
     */
    public function getPersistentCollectionFactory()
    {
        return $this->persistentCollectionFactory;
    }

    /**
     * @param $persistentCollectionFactory
     *
     * @return $this
     */
    public function setPersistentCollectionFactory($persistentCollectionFactory)
    {
        $this->persistentCollectionFactory = (string)$persistentCollectionFactory;

        return $this;
    }

    /**
     * @return string
     */
    public function getPersistentCollectionGenerator()
    {
        return $this->persistentCollectionGenerator;
    }

    /**
     * @param string $persistentCollectionGenerator
     *
     * @return $this
     */
    public function setPersistentCollectionGenerator($persistentCollectionGenerator)
    {
        $this->persistentCollectionGenerator = (string)$persistentCollectionGenerator;

        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getDefaultDb()
    {
        return $this->defaultDb;
    }

    /**
     *
     * @param string|null $defaultDb
     * @return $this
     */
    public function setDefaultDb($defaultDb)
    {
        if ($defaultDb === null) {
            $this->defaultDb = $defaultDb;
        } else {
            $this->defaultDb = (string) $defaultDb;
        }

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     *
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     *
     * @param \DoctrineMongoODMModule\Logging\Logger $logger
     * @return $this
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return \DoctrineMongoODMModule\Logging\Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return string
     */
    public function getClassMetadataFactoryName()
    {
        return $this->classMetadataFactoryName;
    }

    /**
     * @param string $classMetadataFactoryName
     */
    public function setClassMetadataFactoryName($classMetadataFactoryName)
    {
        $this->classMetadataFactoryName = (string) $classMetadataFactoryName;
    }

    /**
     * @param int $retryConnect
     * @return $this
     */
    public function setRetryConnect($retryConnect)
    {
        $this->retryConnect = (int) $retryConnect;
        return $this;
    }

    /**
     * @return int
     */
    public function getRetryConnect()
    {
        return $this->retryConnect;
    }

    /**
     * @param int $retryQuery
     * @return $this
     */
    public function setRetryQuery($retryQuery)
    {
        $this->retryQuery = (int) $retryQuery;
        return $this;
    }

    /**
     * @return int
     */
    public function getRetryQuery()
    {
        return $this->retryQuery;
    }

    /**
     * @param array $types
     */
    public function setTypes(array $types)
    {
        $this->types = $types;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return string
     */
    public function getRepositoryFactory()
    {
        return $this->repositoryFactory;
    }

    /**
     * @param string $repositoryFactory
     * @return \DoctrineMongoODMModule\Options\Configuration
     */
    public function setRepositoryFactory($repositoryFactory)
    {
        $this->repositoryFactory = (string) $repositoryFactory;
        return $this;
    }
}
