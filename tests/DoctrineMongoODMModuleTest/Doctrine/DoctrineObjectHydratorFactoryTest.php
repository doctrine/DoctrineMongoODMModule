<?php
namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineMongoODMModule\Service\DoctrineObjectHydratorFactory;
use PHPUnit\Framework\TestCase;
use Zend\Hydrator\HydratorPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineObjectHydratorFactoryTest extends TestCase
{
    /** @var ServiceLocatorInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $services;

    protected function setUp()
    {
        parent::setUp();

        $this->services = $this->createMock(ServiceLocatorInterface::class);

        $this->services
            ->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->willReturn($this->prophesize(DocumentManager::class)->reveal());
    }

    public function testReturnsHydratorInstance()
    {
        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory($this->services, DoctrineObject::class);

        $this->assertInstanceOf(DoctrineObject::class, $hydrator);
    }

    public function testReturnsHydratorInstanceV2()
    {
        /** @var HydratorPluginManager $hydratorPluginManager */
        $hydratorPluginManager = $this->getMockBuilder(HydratorPluginManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hydratorPluginManager
            ->expects($this->once())
            ->method('getServiceLocator')
            ->willReturn($this->services);

        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory->createService($hydratorPluginManager);

        $this->assertInstanceOf(DoctrineObject::class, $hydrator);
    }
}
