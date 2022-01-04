<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Options;

use Doctrine\ODM\MongoDB\Configuration as MongoDbConfiguration;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository as DefaultDocumentRepository;
use Laminas\Stdlib\AbstractOptions;

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
     */
    protected string $metadataCache = 'array';

    /**
     * Automatic generation of proxies (disable for production!)
     *
     * @psalm-var MongoDbConfiguration::AUTOGENERATE_*
     */
    protected int $generateProxies = MongoDbConfiguration::AUTOGENERATE_EVAL;

    /**
     * Proxy directory.
     */
    protected string $proxyDir = 'data';

    /**
     * Proxy namespace.
     */
    protected string $proxyNamespace = 'DoctrineMongoODMModule\Proxy';

    /**
     * Automatic generation of hydrators (disable for production!)
     *
     * @psalm-var MongoDbConfiguration::AUTOGENERATE_*
     */
    protected int $generateHydrators = MongoDbConfiguration::AUTOGENERATE_ALWAYS;

    /**
     * Hydrator directory
     */
    protected string $hydratorDir = 'data';

    /**
     * Hydrator namespace
     */
    protected string $hydratorNamespace = 'DoctrineMongoODMModule\Hydrator';

    /**
     * Persistent collection generation strategy.
     *
     * @psalm-var MongoDbConfiguration::AUTOGENERATE_*
     */
    protected int $generatePersistentCollections = MongoDbConfiguration::AUTOGENERATE_ALWAYS;

    /**
     * Persistent collection directory.
     */
    protected string $persistentCollectionDir = 'data';

    /**
     * Persistent collection namespace.
     */
    protected string $persistentCollectionNamespace = 'DoctrineMongoODMModule\PersistentCollection';

    /**
     * Persistent collection factory service name.
     */
    protected ?string $persistentCollectionFactory = null;

    /**
     * Persistent collection generator service name.
     */
    protected ?string $persistentCollectionGenerator = null;

    protected ?string $driver = null;

    protected ?string $defaultDb = null;

    /**
     * An array of filters. Array should be in the form
     * array('filterName' => 'BSON\Filter\Class')
     *
     * @var mixed[]
     */
    protected array $filters = [];

    /**
     * service name of the Logger
     */
    protected ?string $logger = null;

    protected ?string $classMetadataFactoryName = null;

    protected ?string $repositoryFactory = null;

    protected string $defaultDocumentRepositoryClassName = DefaultDocumentRepository::class;

    /**
     * Keys must be the name of the type identifier and value is
     * the class name of the Type
     *
     * @var mixed[]
     */
    protected array $types = [];

    /**
     * @return $this
     */
    public function setDriver(string $driver)
    {
        $this->driver = (string) $driver;

        return $this;
    }

    public function getDriver(): string
    {
        return 'doctrine.driver.' . $this->driver;
    }

    /**
     * @psalm-param MongoDbConfiguration::AUTOGENERATE_* $generateProxies
     *
     * @return $this
     */
    public function setGenerateProxies(int $generateProxies)
    {
        $this->generateProxies = $generateProxies;

        return $this;
    }

    /**
     * @psalm-return MongoDbConfiguration::AUTOGENERATE_*
     */
    public function getGenerateProxies(): int
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

    public function getMetadataCache(): string
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

    public function getProxyDir(): string
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

    public function getProxyNamespace(): string
    {
        return $this->proxyNamespace;
    }

    /**
     * @psalm-return MongoDbConfiguration::AUTOGENERATE_*
     */
    public function getGenerateHydrators(): int
    {
        return $this->generateHydrators;
    }

    /**
     * @psalm-param MongoDbConfiguration::AUTOGENERATE_* $generateHydrators
     *
     * @return $this
     */
    public function setGenerateHydrators(int $generateHydrators): Configuration
    {
        $this->generateHydrators = $generateHydrators;

        return $this;
    }

    public function getHydratorDir(): string
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

    public function getHydratorNamespace(): string
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

    /**
     * @psalm-return MongoDbConfiguration::AUTOGENERATE_*
     */
    public function getGeneratePersistentCollections(): int
    {
        return $this->generatePersistentCollections;
    }

    /**
     * @psalm-param MongoDbConfiguration::AUTOGENERATE_* $generatePersistentCollections
     *
     * @return $this
     */
    public function setGeneratePersistentCollections(int $generatePersistentCollections)
    {
        $this->generatePersistentCollections = (int) $generatePersistentCollections;

        return $this;
    }

    public function getPersistentCollectionDir(): string
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

    public function getPersistentCollectionNamespace(): string
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

    public function getPersistentCollectionFactory(): ?string
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

    public function getPersistentCollectionGenerator(): ?string
    {
        return $this->persistentCollectionGenerator;
    }

    /**
     * @return $this
     */
    public function setPersistentCollectionGenerator(?string $persistentCollectionGenerator)
    {
        $this->persistentCollectionGenerator = (string) $persistentCollectionGenerator;

        return $this;
    }

    public function getDefaultDb(): ?string
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
    public function getFilters(): array
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

    public function setLogger(?string $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function getLogger(): ?string
    {
        return $this->logger;
    }

    public function getClassMetadataFactoryName(): ?string
    {
        return $this->classMetadataFactoryName;
    }

    public function setClassMetadataFactoryName(?string $classMetadataFactoryName): void
    {
        $this->classMetadataFactoryName = (string) $classMetadataFactoryName;
    }

    /**
     * @param mixed[] $types
     */
    public function setTypes(array $types): void
    {
        $this->types = $types;
    }

    /**
     * @return mixed[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function getRepositoryFactory(): ?string
    {
        return $this->repositoryFactory;
    }

    public function setRepositoryFactory(?string $repositoryFactory): Configuration
    {
        $this->repositoryFactory = (string) $repositoryFactory;

        return $this;
    }

    public function getDefaultDocumentRepositoryClassName(): string
    {
        return $this->defaultDocumentRepositoryClassName;
    }

    public function setDefaultDocumentRepositoryClassName(string $defaultDocumentRepositoryClassName): self
    {
        $this->defaultDocumentRepositoryClassName = $defaultDocumentRepositoryClassName;

        return $this;
    }
}
