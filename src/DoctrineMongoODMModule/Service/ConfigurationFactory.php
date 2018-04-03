<?php
namespace DoctrineMongoODMModule\Service;

use DoctrineModule\Service\AbstractFactory;
use DoctrineMongoODMModule\Options;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\Types\Type;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory to create MongoDB configuration object.
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConfigurationFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return Configuration
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var $options Options\Configuration */
        $options = $this->getOptions($container, 'configuration');

        $config = new Configuration;

        // logger
        if ($options->getLogger()) {
            $logger = $container->get($options->getLogger());
            $config->setLoggerCallable([$logger, 'log']);
        }

        // proxies
        $config->setAutoGenerateProxyClasses($options->getGenerateProxies());
        $config->setProxyDir($options->getProxyDir());
        $config->setProxyNamespace($options->getProxyNamespace());

        // hydrators
        $config->setAutoGenerateHydratorClasses($options->getGenerateHydrators());
        $config->setHydratorDir($options->getHydratorDir());
        $config->setHydratorNamespace($options->getHydratorNamespace());

        // persistent collections
        $config->setAutoGeneratePersistentCollectionClasses($options->getGeneratePersistentCollections());
        $config->setPersistentCollectionDir($options->getPersistentCollectionDir());
        $config->setPersistentCollectionNamespace($options->getPersistentCollectionNamespace());

        if ($options->getPersistentCollectionFactory()) {
            $config->setPersistentCollectionFactory($container->get($options->getPersistentCollectionFactory()));
        }

        if ($options->getPersistentCollectionGenerator()) {
            $config->setPersistentCollectionGenerator($container->get($options->getPersistentCollectionGenerator()));
        }

        // default db
        $config->setDefaultDB($options->getDefaultDb());

        // caching
        $config->setMetadataCacheImpl($container->get($options->getMetadataCache()));

        // retries
        $config->setRetryConnect($options->getRetryConnect());
        $config->setRetryQuery($options->getRetryQuery());

        // Register filters
        foreach ($options->getFilters() as $alias => $class) {
            $config->addFilter($alias, $class);
        }

        // the driver
        $config->setMetadataDriverImpl($container->get($options->getDriver()));

        // metadataFactory, if set
        if ($factoryName = $options->getClassMetadataFactoryName()) {
            $config->setClassMetadataFactoryName($factoryName);
        }

        // respositoryFactory, if set
        if ($repositoryFactory = $options->getRepositoryFactory()) {
            $config->setRepositoryFactory($container->get($repositoryFactory));
        }

        // custom types
        foreach ($options->getTypes() as $name => $class) {
            if (Type::hasType($name)) {
                Type::overrideType($name, $class);
            } else {
                Type::addType($name, $class);
            }
        }

        return $config;
    }

    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Configuration::class);
    }

    public function getOptionsClass()
    {
        return Options\Configuration::class;
    }
}
