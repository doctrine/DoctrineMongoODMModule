<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use PHPUnit_Framework_TestCase as TestCase;
use DoctrineMongoODMModule\Service\DoctrineObjectHydratorFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

class DoctrineObjectHydratorFactoryTest extends TestCase
{
    public function testReturnsHydratorInstance()
    {
        $serviceLocatorInterface = $this->getMock(ServiceLocatorInterface::class);

        $serviceLocatorInterface
            ->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->willReturn(
                $this->getMockBuilder(DocumentManager::class)
                     ->disableOriginalConstructor()
                     ->getMock()
            );

        /** @var HydratorPluginManager $hydratorPluginManager */
        $hydratorPluginManager = $this->getMock(HydratorPluginManager::class);

        $hydratorPluginManager
            ->expects($this->once())
            ->method('getServiceLocator')
            ->willReturn(
                $serviceLocatorInterface
            );


        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory($hydratorPluginManager);

        $this->assertInstanceOf(DoctrineObject::class, $hydrator);
    }
}
