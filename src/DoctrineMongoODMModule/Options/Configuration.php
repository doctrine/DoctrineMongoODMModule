<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Options;

use Doctrine\Common\Proxy\AbstractProxyFactory;
use DoctrineMongoODMModule\Logging\Logger;
use Laminas\Stdlib\AbstractOptions;
use function is_bool;

/**
 * Configuration options for doctrine mongo
 *
 * @link    http://www.doctrine-project.org/
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
     * @var bool
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

    /** @var string */
    protected $driver;

    /** @var string */
    protected $defaultDb;

    /**
     * An array of filters. Array should be in the form
     * array('filterName' => 'BSON\Filter\Class')
     *
     * @var mixed[]
     */
    protected $filters = [];

    /** @var Logger */
    protected $logger;

    /** @var string */
    protected $classMetadataFactoryName;

    /** @var string */
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
     * @var mixed[]
     */
    protected $types = [];

    /**
     * @return $this
     */
    public function setDriver(string $driver)
    {
        $this->driver = (string) $driver;

        return $this;
    }

    public function getDriver() : string
    {
        return 'doctrine.driver.' . $this->driver;
    }

    /**
     * @return $this
     */
    public function setGenerateProxies(int $generateProxies)
    {
        if (is_bool($generateProxies)) {
            $generateProxies = $generateProxies
                ? AbstractProxyFactory::AUTOGENERATE_ALWAYS
                : AbstractProxyFactory::AUTOGENERATE_NEVER;
        }

        $this->generateProxies = $generateProxies;

        return $this;
    }

    public function getGenerateProxies() : int
    {
        return $this->generateProxies;
    }

    /**
     * @return $this
     */
    public function setMetadataCache(string $metadataCache)
    {
        $this->metadataCache = (string) $metadataCache;

        return $this;
    }

    public function getMetadataCache() : string
    {
        return 'doctrine.cache.' . $this->metadataCache;
    }

    /**
     * @return $this
     */
    public function setProxyDir(string $proxyDir)
    {
        $this->proxyDir = (string) $proxyDir;

        return $this;
    }

    public function getProxyDir() : string
    {
        return $this->proxyDir;
    }

    /**
     * @return $this
     */
    public function setProxyNamespace(string $proxyNamespace)
    {
        $this->proxyNamespace = (string) $proxyNamespace;

        return $this;
    }

    public function getProxyNamespace() : string
    {
        return $this->proxyNamespace;
    }

    public function getGenerateHydrators() : bool
    {
        return $this->generateHydrators;
    }

    /**
     * @param bool|int $generateHydrators
     */
    public function setGenerateHydrators($generateHydrators) : Configuration
    {
        $this->generateHydrators = $generateHydrators;

        return $this;
    }

    public function getHydratorDir() : string
    {
        return $this->hydratorDir;
    }

    /**
     * @return $this
     */
    public function setHydratorDir(string $hydratorDir)
    {
        $this->hydratorDir = (string) $hydratorDir;

        return $this;
    }

    public function getHydratorNamespace() : string
    {
        return $this->hydratorNamespace;
    }

    /**
     * @return $this
     */
    public function setHydratorNamespace(string $hydratorNamespace)
    {
        $this->hydratorNamespace = (string) $hydratorNamespace;

        return $this;
    }

    public function getGeneratePersistentCollections() : int
    {
        return $this->generatePersistentCollections;
    }

    /**
     * @return $this
     */
    public function setGeneratePersistentCollections(int $generatePersistentCollections)
    {
        $this->generatePersistentCollections = (int) $generatePersistentCollections;

        return $this;
    }

    public function getPersistentCollectionDir() : string
    {
        return $this->persistentCollectionDir;
    }

    /**
     * @return $this
     */
    public function setPersistentCollectionDir(string $persistentCollectionDir)
    {
        $this->persistentCollectionDir = (string) $persistentCollectionDir;

        return $this;
    }

    public function getPersistentCollectionNamespace() : string
    {
        return $this->persistentCollectionNamespace;
    }

    /**
     * @return $this
     */
    public function setPersistentCollectionNamespace(string $persistentCollectionNamespace)
    {
        $this->persistentCollectionNamespace = (string) $persistentCollectionNamespace;

        return $this;
    }

    public function getPersistentCollectionFactory() : string
    {
        return $this->persistentCollectionFactory;
    }

    /**
     * @param mixed $persistentCollectionFactory
     *
     * @return $this
     */
    public function setPersistentCollectionFactory($persistentCollectionFactory)
    {
        $this->persistentCollectionFactory = (string) $persistentCollectionFactory;

        return $this;
    }

    public function getPersistentCollectionGenerator() : string
    {
        return $this->persistentCollectionGenerator;
    }

    /**
     * @return $this
     */
    public function setPersistentCollectionGenerator(string $persistentCollectionGenerator)
    {
        $this->persistentCollectionGenerator = (string) $persistentCollectionGenerator;

        return $this;
    }

    public function getDefaultDb() : ?string
    {
        return $this->defaultDb;
    }

    /**
     * @return $this
     */
    public function setDefaultDb(?string $defaultDb)
    {
        if ($defaultDb === null) {
            $this->defaultDb = $defaultDb;
        } else {
            $this->defaultDb = (string) $defaultDb;
        }

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getFilters() : array
    {
        return $this->filters;
    }

    /**
     * @param mixed[] $filters
     *
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @return $this
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    public function getLogger() : Logger
    {
        return $this->logger;
    }

    public function getClassMetadataFactoryName() : string
    {
        return $this->classMetadataFactoryName;
    }

    public function setClassMetadataFactoryName(string $classMetadataFactoryName) : void
    {
        $this->classMetadataFactoryName = (string) $classMetadataFactoryName;
    }

    /**
     * @return $this
     */
    public function setRetryConnect(int $retryConnect)
    {
        $this->retryConnect = (int) $retryConnect;

        return $this;
    }

    public function getRetryConnect() : int
    {
        return $this->retryConnect;
    }

    /**
     * @return $this
     */
    public function setRetryQuery(int $retryQuery)
    {
        $this->retryQuery = (int) $retryQuery;

        return $this;
    }

    public function getRetryQuery() : int
    {
        return $this->retryQuery;
    }

    /**
     * @param mixed[] $types
     */
    public function setTypes(array $types) : void
    {
        $this->types = $types;
    }

    /**
     * @return mixed[]
     */
    public function getTypes() : array
    {
        return $this->types;
    }

    public function getRepositoryFactory() : string
    {
        return $this->repositoryFactory;
    }

    public function setRepositoryFactory(string $repositoryFactory) : Configuration
    {
        $this->repositoryFactory = (string) $repositoryFactory;

        return $this;
    }
}
