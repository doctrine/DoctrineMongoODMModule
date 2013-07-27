<?php

namespace DoctrineMongoODMModuleTest\Service;

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
}
