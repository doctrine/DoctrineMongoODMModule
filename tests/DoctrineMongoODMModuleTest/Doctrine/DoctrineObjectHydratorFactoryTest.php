<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use PHPUnit_Framework_TestCase as TestCase;
use DoctrineMongoODMModule\Service\DoctrineObjectHydratorFactory;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

class DoctrineObjectHydratorFactoryTest extends TestCase
{
    public function testReturnsHydratorInstance()
    {
        $serviceLocatorInterface = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $serviceLocatorInterface
            ->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->willReturn(
                $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
                     ->disableOriginalConstructor()
                     ->getMock()
            );

        /** @var HydratorPluginManager $hydratorPluginManager */
        $hydratorPluginManager = $this->getMock('Zend\Stdlib\Hydrator\HydratorPluginManager');

        $hydratorPluginManager
            ->expects($this->once())
            ->method('getServiceLocator')
            ->willReturn(
                $serviceLocatorInterface
            );


        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory($hydratorPluginManager);

        $this->assertInstanceOf('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $hydrator);
    }
}
