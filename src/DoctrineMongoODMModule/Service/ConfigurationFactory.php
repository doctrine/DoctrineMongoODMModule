<?php

declare(strict_types=1);

namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\Types\Type;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

use function assert;

/**
 * Factory to create MongoDB configuration object.
 *
 * @link    http://www.doctrine-project.org/
 */
class ConfigurationFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return Configuration
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $configurationOptions = $this->getOptions($container, 'configuration');
        assert($configurationOptions instanceof Options\Configuration);

        $config = new Configuration();

        // logger
        $logger = $configurationOptions->getLogger();
        if ($logger !== null) {
            $container->get($logger);
        }

        // proxies
        $config->setAutoGenerateProxyClasses($configurationOptions->getGenerateProxies());
        $config->setProxyDir($configurationOptions->getProxyDir());
        $config->setProxyNamespace($configurationOptions->getProxyNamespace());

        // hydrators
        $config->setAutoGenerateHydratorClasses($configurationOptions->getGenerateHydrators());
        $config->setHydratorDir($configurationOptions->getHydratorDir());
        $config->setHydratorNamespace($configurationOptions->getHydratorNamespace());

        // persistent collections
        $config->setAutoGeneratePersistentCollectionClasses($configurationOptions->getGeneratePersistentCollections());
        $config->setPersistentCollectionDir($configurationOptions->getPersistentCollectionDir());
        $config->setPersistentCollectionNamespace($configurationOptions->getPersistentCollectionNamespace());

        if ($configurationOptions->getPersistentCollectionFactory()) {
            $config->setPersistentCollectionFactory(
                $container->get($configurationOptions->getPersistentCollectionFactory())
            );
        }

        if ($configurationOptions->getPersistentCollectionGenerator()) {
            $config->setPersistentCollectionGenerator(
                $container->get($configurationOptions->getPersistentCollectionGenerator())
            );
        }

        // default db
        $defaultDb = $configurationOptions->getDefaultDb();
        if ($defaultDb !== null) {
            $config->setDefaultDB($defaultDb);
        }

        // caching
        $config->setMetadataCacheImpl($container->get($configurationOptions->getMetadataCache()));

        // Register filters
        foreach ($configurationOptions->getFilters() as $alias => $class) {
            $config->addFilter($alias, $class);
        }

        // the driver
        $config->setMetadataDriverImpl($container->get($configurationOptions->getDriver()));

        // metadataFactory, if set
        $factoryName = $configurationOptions->getClassMetadataFactoryName();
        if ($factoryName) {
            $config->setClassMetadataFactoryName($factoryName);
        }

        // respositoryFactory, if set
        $repositoryFactory = $configurationOptions->getRepositoryFactory();
        if ($repositoryFactory) {
            $config->setRepositoryFactory($container->get($repositoryFactory));
        }

        // custom types
        foreach ($configurationOptions->getTypes() as $name => $class) {
            if (Type::hasType($name)) {
                Type::overrideType($name, $class);
            } else {
                Type::addType($name, $class);
            }
        }

        $className = $configurationOptions->getDefaultDocumentRepositoryClassName();
        if ($className) {
            $config->setDefaultDocumentRepositoryClassName($className);
        }

        return $config;
    }

    /**
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Configuration::class);
    }

    public function getOptionsClass() : string
    {
        return Options\Configuration::class;
    }
}
