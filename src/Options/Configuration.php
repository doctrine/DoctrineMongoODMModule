<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Options;

use Doctrine\ODM\MongoDB\Configuration as MongoDbConfiguration;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository as DefaultDocumentRepository;
use Laminas\Stdlib\AbstractOptions;

/**
 * Configuration options for doctrine mongo
 */
final class Configuration extends AbstractOptions
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

    public function setDriver(string $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function getDriver(): string
    {
        return 'doctrine.driver.' . $this->driver;
    }

    /**
     * @psalm-param MongoDbConfiguration::AUTOGENERATE_* $generateProxies
     */
    public function setGenerateProxies(int $generateProxies): self
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

    public function setMetadataCache(string $metadataCache): self
    {
        $this->metadataCache = $metadataCache;

        return $this;
    }

    public function getMetadataCache(): string
    {
        return 'doctrine.cache.' . $this->metadataCache;
    }

    public function setProxyDir(string $proxyDir): self
    {
        $this->proxyDir = $proxyDir;

        return $this;
    }

    public function getProxyDir(): string
    {
        return $this->proxyDir;
    }

    public function setProxyNamespace(string $proxyNamespace): self
    {
        $this->proxyNamespace = $proxyNamespace;

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
     */
    public function setGenerateHydrators(int $generateHydrators): self
    {
        $this->generateHydrators = $generateHydrators;

        return $this;
    }

    public function getHydratorDir(): string
    {
        return $this->hydratorDir;
    }

    public function setHydratorDir(string $hydratorDir): self
    {
        $this->hydratorDir = $hydratorDir;

        return $this;
    }

    public function getHydratorNamespace(): string
    {
        return $this->hydratorNamespace;
    }

    public function setHydratorNamespace(string $hydratorNamespace): self
    {
        $this->hydratorNamespace = $hydratorNamespace;

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
     */
    public function setGeneratePersistentCollections(int $generatePersistentCollections): self
    {
        $this->generatePersistentCollections = (int) $generatePersistentCollections;

        return $this;
    }

    public function getPersistentCollectionDir(): string
    {
        return $this->persistentCollectionDir;
    }

    public function setPersistentCollectionDir(string $persistentCollectionDir): self
    {
        $this->persistentCollectionDir = $persistentCollectionDir;

        return $this;
    }

    public function getPersistentCollectionNamespace(): string
    {
        return $this->persistentCollectionNamespace;
    }

    public function setPersistentCollectionNamespace(string $persistentCollectionNamespace): self
    {
        $this->persistentCollectionNamespace = $persistentCollectionNamespace;

        return $this;
    }

    public function getPersistentCollectionFactory(): ?string
    {
        return $this->persistentCollectionFactory;
    }

    public function setPersistentCollectionFactory(?string $persistentCollectionFactory): self
    {
        $this->persistentCollectionFactory = $persistentCollectionFactory;

        return $this;
    }

    public function getPersistentCollectionGenerator(): ?string
    {
        return $this->persistentCollectionGenerator;
    }

    public function setPersistentCollectionGenerator(?string $persistentCollectionGenerator): self
    {
        $this->persistentCollectionGenerator = (string) $persistentCollectionGenerator;

        return $this;
    }

    public function getDefaultDb(): ?string
    {
        return $this->defaultDb;
    }

    public function setDefaultDb(?string $defaultDb): self
    {
        $this->defaultDb = $defaultDb;

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
     */
    public function setFilters(array $filters): self
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
