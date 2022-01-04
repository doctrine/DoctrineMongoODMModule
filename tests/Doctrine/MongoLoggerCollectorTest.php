<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Collector\MongoLoggerCollector;
use DoctrineMongoODMModule\Logging\DebugStack;
use PHPUnit\Framework\TestCase;

class MongoLoggerCollectorTest extends TestCase
{
    private DebugStack $logger;
    private MongoLoggerCollector $collector;

    protected function setUp(): void
    {
        $this->logger    = new DebugStack();
        $this->collector = new MongoLoggerCollector($this->logger, 'my-logger');
    }

    public function testGetName(): void
    {
        $this->assertSame('my-logger', $this->collector->getName());
    }

    public function testPriority(): void
    {
        $this->assertSame(10, $this->collector->getPriority());
    }

    public function testCanHideIfQueryCountIsZero(): void
    {
        $this->assertTrue($this->collector->canHide());
    }

    public function testCannotHideIfQueriesAreLogged(): void
    {
        $this->logger->queries = ['foo'];

        $this->assertFalse($this->collector->canHide());
    }

    public function testDefaultQueryCount(): void
    {
        $this->assertSame(0, $this->collector->getQueryCount());
    }

    public function testQueryCount(): void
    {
        $this->logger->queries = [
            'first query',
            'second query',
        ];

        $this->assertSame(2, $this->collector->getQueryCount());
    }

    public function testGetQueries(): void
    {
        $queries = [
            'first query',
            'second query',
        ];

        $this->logger->queries = $queries;

        $this->assertSame($queries, $this->collector->getQueries());
    }

    public function testQueryTimeIsZero(): void
    {
        $this->assertSame(0.0, $this->collector->getQueryTime());
    }
}
