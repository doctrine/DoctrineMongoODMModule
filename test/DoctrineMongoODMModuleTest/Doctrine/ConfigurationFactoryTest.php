<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Service;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\PersistentCollection\PersistentCollectionFactory;
use Doctrine\ODM\MongoDB\PersistentCollection\PersistentCollectionGenerator;
use Doctrine\ODM\MongoDB\Types\Type;
use DoctrineMongoODMModule\Logging\Logger;
use DoctrineMongoODMModule\Service\ConfigurationFactory;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\CustomRepositoryFactory;
use DoctrineMongoODMModuleTest\Assets\CustomType;
use Laminas\ServiceManager\ServiceManager;
use function assert;
use function is_callable;

final class ConfigurationFactoryTest extends AbstractTest
{
    public function testRetryConnectValueIsSetFromConfigurationOptions() : void
    {
        $config = $this->getDocumentManager()->getConfiguration();

        $this->assertSame(123, $config->getRetryConnect());
    }

    public function testRetryQueryValueIsSetFromConfigurationOptions() : void
    {
        $config = $this->getDocumentManager()->getConfiguration();

        $this->assertSame(456, $config->getRetryQuery());
    }

    public function testCreation() : void
    {
        $serviceLocator = new ServiceManager();

        $serviceLocator->setService('stubbed_logger', $this->getMockForAbstractClass(Logger::class));

        $serviceLocator->setService(
            'doctrine.cache.stubbed_metadatacache',
            $metadataCache = $this->getMockForAbstractClass(Cache::class)
        );

        $serviceLocator->setService(
            'doctrine.driver.stubbed_driver',
            $mappingDriver = $this->getMockForAbstractClass(MappingDriver::class)
        );

        $serviceLocator->setService(
            CustomRepositoryFactory::class,
            $repositoryFactory = new CustomRepositoryFactory()
        );

        $serviceLocator->setService(
            PersistentCollectionFactory::class,
            $persistentCollectionFactory = $this->getMockForAbstractClass(PersistentCollectionFactory::class)
        );

        $serviceLocator->setService(
            PersistentCollectionGenerator::class,
            $persistentCollectionGenerator = $this->getMockForAbstractClass(PersistentCollectionGenerator::class)
        );

        $serviceLocator->setService(
            'config',
            [
                'doctrine' => [
                    'configuration' => [
                        'odm_test' => [
                            'logger' => 'stubbed_logger',
                            'metadata_cache' => 'stubbed_metadatacache',
                            'driver' => 'stubbed_driver',

                            'generate_proxies' => $proxyGenerate = false,
                            'proxy_dir' => $proxyDir             = 'dir/proxy',
                            'proxy_namespace' => $proxyNamespace = 'ns\proxy',

                            'generate_hydrators' => $hydratorGenerate  = true,
                            'hydrator_dir' => $hydratorDir             = 'dir/hydrator',
                            'hydrator_namespace' => $hydratorNamespace = 'ns\hydrator',
                            // phpcs:disable Generic.Files.LineLength
                            'generate_persistent_collections' => $collectionGenerate = Configuration::AUTOGENERATE_EVAL,
                            // phpcs:enable Generic.Files.LineLength
                            'persistent_collection_dir' => $collectionDir             = 'dir/collection',
                            'persistent_collection_namespace' => $collectionNamespace = 'ns\collection',
                            'persistent_collection_factory' => PersistentCollectionFactory::class,
                            'persistent_collection_generator' => PersistentCollectionGenerator::class,

                            'default_db' => 'default_db',
                            'filters' => [], // ['filterName' => 'BSON\Filter\Class']
                            'types' => [$typeName = 'foo_type' => $typeClassName = CustomType::class],
                            'classMetadataFactoryName' => 'stdClass',
                            'repositoryFactory' => CustomRepositoryFactory::class,
                        ],
                    ],
                ],
            ]
        );

        $factory = new ConfigurationFactory('odm_test');

        $config = $factory->createService($serviceLocator);
        assert($config instanceof Configuration);

        self::assertInstanceOf(Configuration::class, $config);
        self::assertTrue(is_callable($config->getLoggerCallable()));

        self::assertSame($metadataCache, $config->getMetadataCacheImpl());
        self::assertSame($mappingDriver, $config->getMetadataDriverImpl());

        self::assertSame(AbstractProxyFactory::AUTOGENERATE_NEVER, $config->getAutoGenerateProxyClasses());
        self::assertSame($proxyDir, $config->getProxyDir());
        self::assertSame($proxyNamespace, $config->getProxyNamespace());

        self::assertTrue($config->getAutoGenerateHydratorClasses());
        self::assertSame($hydratorDir, $config->getHydratorDir());
        self::assertSame($hydratorNamespace, $config->getHydratorNamespace());

        self::assertSame($collectionGenerate, $config->getAutoGeneratePersistentCollectionClasses());
        self::assertSame($collectionDir, $config->getPersistentCollectionDir());
        self::assertSame($collectionNamespace, $config->getPersistentCollectionNamespace());
        self::assertSame($persistentCollectionFactory, $config->getPersistentCollectionFactory());
        self::assertSame($persistentCollectionGenerator, $config->getPersistentCollectionGenerator());

        self::assertInstanceOf($typeClassName, Type::getType($typeName));
        self::assertSame($repositoryFactory, $config->getRepositoryFactory());
    }
}
