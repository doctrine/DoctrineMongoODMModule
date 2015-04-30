<?php

namespace DoctrineMongoODMModuleTest\Service;

use DoctrineMongoODMModule\Service\ConfigurationFactory;
use DoctrineMongoODMModuleTest\AbstractTest;

class ConfigurationFactoryTest extends AbstractTest
{
    public function testRetryConnectValueIsSetFromConfigurationOptions()
    {
        $config = $this->getDocumentManager()->getConfiguration();

        $this->assertSame(123, $config->getRetryConnect());
    }

    public function testRetryQueryValueIsSetFromConfigurationOptions()
    {
        $config = $this->getDocumentManager()->getConfiguration();

        $this->assertSame(456, $config->getRetryQuery());
    }

    public function testCreation()
    {
        $logger        = $this->getMockForAbstractClass('DoctrineMongoODMModule\Logging\Logger');
        $metadataCache = $this->getMockForAbstractClass('Doctrine\Common\Cache\Cache');
        $mappingDriver = $this->getMockForAbstractClass('Doctrine\Common\Persistence\Mapping\Driver\MappingDriver');

        $serviceLocator = $this->getMockForAbstractClass('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocator->expects($this->exactly(4))->method('get')->withConsecutive(
            array('Configuration'),
            array('stubbed_logger'),
            array('doctrine.cache.stubbed_metadatacache'),
            array('doctrine.driver.stubbed_driver')
        )->willReturnOnConsecutiveCalls(
            array(
                'doctrine' => array(
                    'configuration' => array(
                        'odm_test' => array(
                            'logger'             => 'stubbed_logger',
                            'metadata_cache'     => 'stubbed_metadatacache',
                            'driver'             => 'stubbed_driver',
                            'generate_proxies'   => true,
                            'proxy_dir'          => 'data/DoctrineMongoODMModule/Proxy',
                            'proxy_namespace'    => 'DoctrineMongoODMModule\Proxy',
                            'generate_hydrators' => true,
                            'hydrator_dir'       => 'data/DoctrineMongoODMModule/Hydrator',
                            'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',
                            'default_db'         => 'default_db',
                            'filters'            => array(),  // array('filterName' => 'BSON\Filter\Class')
                            // custom types
                            'types'              => array(
                                'CustomType' => 'DoctrineMongoODMModuleTest\Assets\CustomType'
                            ),
                            'classMetadataFactoryName' => 'stdClass'
                        )
                    )
                )
            ),
            $logger,
            $metadataCache,
            $mappingDriver
        );

        $factory = new ConfigurationFactory('odm_test');
        $config = $factory->createService($serviceLocator);

        $this->assertInstanceOf('Doctrine\ODM\MongoDB\Configuration', $config);
        $this->assertNotNull($config->getLoggerCallable());
        $this->assertSame($metadataCache, $config->getMetadataCacheImpl());
        $this->assertSame($mappingDriver, $config->getMetadataDriverImpl());
        $this->assertInstanceOf(
            'DoctrineMongoODMModuleTest\Assets\CustomType',
            \Doctrine\ODM\MongoDB\Types\Type::getType('CustomType')
        );
    }
}
