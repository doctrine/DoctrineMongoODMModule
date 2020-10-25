<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Collector\MongoLoggerCollector;
use DoctrineMongoODMModule\Logging\DebugStack;
use PHPUnit\Framework\TestCase;

class MongoLoggerCollectorTest extends TestCase
{
    /** @var DebugStack */
    private $logger;
    /** @var MongoLoggerCollector */
    private $collector;

    protected function setUp() : void
    {
        $this->logger    = new DebugStack();
        $this->collector = new MongoLoggerCollector($this->logger, 'my-logger');
    }

    public function testGetName() : void
    {
        self::assertSame('my-logger', $this->collector->getName());
    }

    public function testPriority() : void
    {
        self::assertSame(10, $this->collector->getPriority());
    }

    public function testCanHideIfQueryCountIsZero() : void
    {
        self::assertTrue($this->collector->canHide());
    }

    public function testCannotHideIfQueriesAreLogged() : void
    {
        $this->logger->queries = ['foo'];

        self::assertFalse($this->collector->canHide());
    }

    public function testDefaultQueryCount() : void
    {
        self::assertSame(0, $this->collector->getQueryCount());
    }

    public function testQueryCount() : void
    {
        $this->logger->queries = [
            'first query',
            'second query',
        ];

        self::assertSame(2, $this->collector->getQueryCount());
    }

    public function testGetQueries() : void
    {
        $queries = [
            'first query',
            'second query',
        ];

        $this->logger->queries = $queries;

        self::assertSame($queries, $this->collector->getQueries());
    }

    public function testQueryTimeIsZero() : void
    {
        self::assertSame(0.0, $this->collector->getQueryTime());
    }
}
