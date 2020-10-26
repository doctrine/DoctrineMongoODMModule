<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Collector\MongoLoggerCollector;
use DoctrineMongoODMModule\Service\MongoLoggerCollectorFactory;
use DoctrineMongoODMModuleTest\AbstractTest;

class MongoLoggerCollectorFactoryTest extends AbstractTest
{
    public function testCreateService(): void
    {
        $collector = $this->serviceManager->get('doctrine.mongo_logger_collector.odm_default');

        self::assertInstanceOf(MongoLoggerCollector::class, $collector);
    }

    public function testCreateServiceWithLegacyCreateServiceMethod(): void
    {
        $factory = new MongoLoggerCollectorFactory('odm_default');

        $collector = $factory->createService($this->serviceManager);

        self::assertInstanceOf(MongoLoggerCollector::class, $collector);
    }
}
