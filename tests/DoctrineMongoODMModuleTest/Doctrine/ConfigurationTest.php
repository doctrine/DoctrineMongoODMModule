<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Options\Configuration;
use PHPUnit\Framework\TestCase;

final class ConfigurationTest extends TestCase
{
    /** @var Configuration */
    private $configuration;

    protected function setUp() : void
    {
        $this->configuration = new Configuration();
    }

    public function testDefaultRetryConnectIsZero() : void
    {
        $this->assertSame(0, $this->configuration->getRetryConnect());
    }

    public function testDefaultRetryQueryIsZero() : void
    {
        $this->assertSame(0, $this->configuration->getRetryQuery());
    }

    public function testSettingRetryConnectValue() : void
    {
        $this->configuration->setRetryConnect(111);
        $this->assertSame(111, $this->configuration->getRetryConnect());
    }

    public function testSettingRetryQueryValue() : void
    {
        $this->configuration->setRetryQuery(222);
        $this->assertSame(222, $this->configuration->getRetryQuery());
    }
}
