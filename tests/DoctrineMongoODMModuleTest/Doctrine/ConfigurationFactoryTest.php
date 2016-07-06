<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */
namespace DoctrineMongoODMModuleTest\Service;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\PersistentCollection\PersistentCollectionFactory;
use Doctrine\ODM\MongoDB\PersistentCollection\PersistentCollectionGenerator;
use Doctrine\ODM\MongoDB\Types\Type;
use DoctrineMongoODMModule\Logging\Logger;
use DoctrineMongoODMModule\Service\ConfigurationFactory;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\CustomType;
use Zend\ServiceManager\ServiceManager;

final class ConfigurationFactoryTest extends AbstractTest
{
    public function testRetryConnectValueIsSetFromConfigurationOptions()
    {
        $config = $this->getDocumentManager()->getConfiguration();

        self::assertSame(123, $config->getRetryConnect());
    }

    public function testRetryQueryValueIsSetFromConfigurationOptions()
    {
        $config = $this->getDocumentManager()->getConfiguration();

        self::assertSame(456, $config->getRetryQuery());
    }

    public function testCreation()
    {
        $serviceLocator = (new ServiceManager)
            ->setService('stubbed_logger', $this->getMockForAbstractClass(Logger::class))
            ->setService(
                'doctrine.cache.stubbed_metadatacache',
                $metadataCache = $this->getMockForAbstractClass(Cache::class)
            )
            ->setService(
                'doctrine.driver.stubbed_driver',
                $mappingDriver = $this->getMockForAbstractClass(MappingDriver::class)
            )
            ->setService(
                PersistentCollectionFactory::class,
                $persistentCollectionFactory = $this->getMockForAbstractClass(PersistentCollectionFactory::class)
            )
            ->setService(
                PersistentCollectionGenerator::class,
                $persistentCollectionGenerator = $this->getMockForAbstractClass(PersistentCollectionGenerator::class)
            )
            ->setService(
                'Configuration',
                [
                    'doctrine' => [
                        'configuration' => [
                            'odm_test' => [
                                'logger' => 'stubbed_logger',
                                'metadata_cache' => 'stubbed_metadatacache',
                                'driver' => 'stubbed_driver',

                                'generate_proxies' => $proxyGenerate = false,
                                'proxy_dir' => $proxyDir = 'dir/proxy',
                                'proxy_namespace' => $proxyNamespace = 'ns\proxy',

                                'generate_hydrators' => $hydratorGenerate = true,
                                'hydrator_dir' => $hydratorDir = 'dir/hydrator',
                                'hydrator_namespace' => $hydratorNamespace = 'ns\hydrator',

                                'generate_persistent_collections' => $collectionGenerate = Configuration::AUTOGENERATE_EVAL,
                                'persistent_collection_dir' => $collectionDir = 'dir/collection',
                                'persistent_collection_namespace' => $collectionNamespace = 'ns\collection',
                                'persistent_collection_factory' => PersistentCollectionFactory::class,
                                'persistent_collection_generator' => PersistentCollectionGenerator::class,

                                'default_db' => 'default_db',
                                'filters' => [], // ['filterName' => 'BSON\Filter\Class']
                                'types' => [$typeName = 'foo_type' => $typeClassName = CustomType::class],
                                'classMetadataFactoryName' => 'stdClass'
                            ]
                        ]
                    ]
                ]
            )
        ;

        $factory = new ConfigurationFactory('odm_test');
        $config = $factory->createService($serviceLocator);

        self::assertInstanceOf(Configuration::class, $config);
        self::assertTrue(is_callable($config->getLoggerCallable()));

        self::assertSame($metadataCache, $config->getMetadataCacheImpl());
        self::assertSame($mappingDriver, $config->getMetadataDriverImpl());

        self::assertFalse($config->getAutoGenerateProxyClasses());
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
    }
}
