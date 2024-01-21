<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\Psr6\CacheAdapter;
use Doctrine\ODM\MongoDB\APM\CommandLoggerInterface;
use Doctrine\ODM\MongoDB\Configuration as Config;
use Doctrine\ODM\MongoDB\PersistentCollection\PersistentCollectionFactory;
use Doctrine\ODM\MongoDB\PersistentCollection\PersistentCollectionGenerator;
use Doctrine\ODM\MongoDB\Types\Type;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use DoctrineMongoODMModule\Service\ConfigurationFactory;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\CustomDocumentRepository;
use DoctrineMongoODMModuleTest\Assets\CustomRepositoryFactory;
use DoctrineMongoODMModuleTest\Assets\CustomType;
use Laminas\ServiceManager\ServiceManager;

use function assert;

final class ConfigurationFactoryTest extends AbstractTest
{
    public function testCreation(): void
    {
        $serviceLocator = new ServiceManager();
        $serviceLocator->setService(
            'stubbed_logger',
            $this->getMockForAbstractClass(CommandLoggerInterface::class),
        );

        $serviceLocator->setService(
            'doctrine.cache.stubbed_metadatacache',
            $metadataCache = $this->getMockForAbstractClass(Cache::class),
        );

        $serviceLocator->setService(
            'doctrine.driver.stubbed_driver',
            $mappingDriver = $this->getMockForAbstractClass(MappingDriver::class),
        );

        $serviceLocator->setService(
            CustomRepositoryFactory::class,
            $repositoryFactory = new CustomRepositoryFactory(),
        );

        $serviceLocator->setService(
            PersistentCollectionFactory::class,
            $persistentCollectionFactory = $this->getMockForAbstractClass(PersistentCollectionFactory::class),
        );

        $serviceLocator->setService(
            PersistentCollectionGenerator::class,
            $persistentCollectionGenerator = $this->getMockForAbstractClass(PersistentCollectionGenerator::class),
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

                            'generate_proxies' => $proxyGenerate  = Config::AUTOGENERATE_EVAL,
                            'proxy_dir'        => $proxyDir       = 'dir/proxy',
                            'proxy_namespace'  => $proxyNamespace = 'ns\proxy',

                            'generate_hydrators'              => $hydratorGenerate    = Config::AUTOGENERATE_ALWAYS,
                            'hydrator_dir'                    => $hydratorDir         = 'dir/hydrator',
                            'hydrator_namespace'              => $hydratorNamespace   = 'ns\hydrator',
                            'generate_persistent_collections' => $collectionGenerate  = Config::AUTOGENERATE_EVAL,
                            'persistent_collection_dir'       => $collectionDir       = 'dir/collection',
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
            ],
        );

        $factory = new ConfigurationFactory('odm_test');
        $config  = $factory($serviceLocator, Config::class);

        assert($config instanceof Config);

        $this->assertInstanceOf(Config::class, $config);

        $this->assertEquals(CacheAdapter::wrap($metadataCache), $config->getMetadataCache());
        $this->assertSame($mappingDriver, $config->getMetadataDriverImpl());

        $this->assertSame(Config::AUTOGENERATE_EVAL, $config->getAutoGenerateProxyClasses());
        $this->assertSame($proxyDir, $config->getProxyDir());
        $this->assertSame($proxyNamespace, $config->getProxyNamespace());

        $this->assertSame($config->getAutoGenerateHydratorClasses(), Config::AUTOGENERATE_ALWAYS);
        $this->assertSame($hydratorDir, $config->getHydratorDir());
        $this->assertSame($hydratorNamespace, $config->getHydratorNamespace());

        $this->assertSame($collectionGenerate, $config->getAutoGeneratePersistentCollectionClasses());
        $this->assertSame($collectionDir, $config->getPersistentCollectionDir());
        $this->assertSame($collectionNamespace, $config->getPersistentCollectionNamespace());
        $this->assertSame($persistentCollectionFactory, $config->getPersistentCollectionFactory());
        $this->assertSame($persistentCollectionGenerator, $config->getPersistentCollectionGenerator());

        $this->assertInstanceOf($typeClassName, Type::getType($typeName));
        $this->assertSame('stdClass', $config->getClassMetadataFactoryName());
        $this->assertSame($repositoryFactory, $config->getRepositoryFactory());
        $this->assertSame(CustomDocumentRepository::class, $config->getDefaultDocumentRepositoryClassName());
    }
}
