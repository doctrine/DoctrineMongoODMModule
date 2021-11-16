<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModule\Service\DoctrineObjectHydratorFactory;
use Laminas\ServiceManager\ServiceLocatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DoctrineObjectHydratorFactoryTest extends TestCase
{
    use ProphecyTrait;

    /** @var ServiceLocatorInterface|MockObject */
    protected $services;

    protected function setUp(): void
    {
        parent::setUp();

        $this->services = $this->createMock(ServiceLocatorInterface::class);

        $this->services
            ->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->willReturn($this->prophesize(DocumentManager::class)->reveal());
    }

    public function testReturnsHydratorInstance(): void
    {
        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory($this->services);

        $this->assertInstanceOf(DoctrineObject::class, $hydrator);
    }
}
