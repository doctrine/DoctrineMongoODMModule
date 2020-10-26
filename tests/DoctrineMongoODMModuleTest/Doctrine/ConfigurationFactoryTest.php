<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\Common\Cache\Cache;
use Doctrine\ODM\MongoDB\APM\CommandLoggerInterface;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\PersistentCollection\PersistentCollectionFactory;
use Doctrine\ODM\MongoDB\PersistentCollection\PersistentCollectionGenerator;
use Doctrine\ODM\MongoDB\Types\Type;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use DoctrineMongoODMModule\Service\ConfigurationFactory;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\CustomRepositoryFactory;
use DoctrineMongoODMModuleTest\Assets\CustomType;
use DoctrineMongoODMModuleTest\Assets\DefaultDocumentRepository as CustomDocumentRepository;
use Laminas\ServiceManager\ServiceManager;

use function assert;

final class ConfigurationFactoryTest extends AbstractTest
{
    public function testCreation() : void
    {
        $serviceLocator = new ServiceManager();
        $serviceLocator->setService(
            'stubbed_logger',
            $this->getMockForAbstractClass(CommandLoggerInterface::class)
        );

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
                            'logger'         => 'stubbed_logger',
                            'metadata_cache' => 'stubbed_metadatacache',
                            'driver'         => 'stubbed_driver',

                            'generate_proxies' => $proxyGenerate = Configuration::AUTOGENERATE_EVAL,
                            'proxy_dir'        => $proxyDir = 'dir/proxy',
                            'proxy_namespace'  => $proxyNamespace = 'ns\proxy',

                            'generate_hydrators'              => $hydratorGenerate = Configuration::AUTOGENERATE_ALWAYS,
                            'hydrator_dir'                    => $hydratorDir = 'dir/hydrator',
                            'hydrator_namespace'              => $hydratorNamespace = 'ns\hydrator',
                            // phpcs:disable Generic.Files.LineLength
                            'generate_persistent_collections' => $collectionGenerate = Configuration::AUTOGENERATE_EVAL,
                            // phpcs:enable Generic.Files.LineLength
                            'persistent_collection_dir'       => $collectionDir = 'dir/collection',
                            'persistent_collection_namespace' => $collectionNamespace = 'ns\collection',
                            'persistent_collection_factory'   => PersistentCollectionFactory::class,
                            'persistent_collection_generator' => PersistentCollectionGenerator::class,

                            'default_db'                             => 'default_db',
                            'filters'                                => [], // ['filterName' => 'BSON\Filter\Class']
                            'types'                                  => [
                                $typeName = 'foo_type' => $typeClassName = CustomType::class,
                            ],
                            'classMetadataFactoryName'               => 'stdClass',
                            'repositoryFactory'                      => CustomRepositoryFactory::class,
                            'default_document_repository_class_name' => CustomDocumentRepository::class,
                        ],
                    ],
                ],
            ]
        );

        $factory = new ConfigurationFactory('odm_test');
        $config  = $factory->createService($serviceLocator);

        assert($config instanceof Configuration);

        self::assertInstanceOf(Configuration::class, $config);

        self::assertSame($metadataCache, $config->getMetadataCacheImpl());
        self::assertSame($mappingDriver, $config->getMetadataDriverImpl());

        self::assertSame(Configuration::AUTOGENERATE_EVAL, $config->getAutoGenerateProxyClasses());
        self::assertSame($proxyDir, $config->getProxyDir());
        self::assertSame($proxyNamespace, $config->getProxyNamespace());

        self::assertSame($config->getAutoGenerateHydratorClasses(), Configuration::AUTOGENERATE_ALWAYS);
        self::assertSame($hydratorDir, $config->getHydratorDir());
        self::assertSame($hydratorNamespace, $config->getHydratorNamespace());

        self::assertSame($collectionGenerate, $config->getAutoGeneratePersistentCollectionClasses());
        self::assertSame($collectionDir, $config->getPersistentCollectionDir());
        self::assertSame($collectionNamespace, $config->getPersistentCollectionNamespace());
        self::assertSame($persistentCollectionFactory, $config->getPersistentCollectionFactory());
        self::assertSame($persistentCollectionGenerator, $config->getPersistentCollectionGenerator());

        self::assertInstanceOf($typeClassName, Type::getType($typeName));
        self::assertSame($repositoryFactory, $config->getRepositoryFactory());

        self::assertSame(CustomDocumentRepository::class, $config->getDefaultDocumentRepositoryClassName());
    }
}
