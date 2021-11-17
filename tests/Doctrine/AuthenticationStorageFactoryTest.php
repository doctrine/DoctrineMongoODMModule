<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationStorageFactoryTest extends AbstractTest
{
    public function testAuthenticationStorageFactory(): void
    {
        $storage = $this->serviceManager->get('doctrine.authenticationstorage.odm_default');
        $this->assertInstanceOf('Laminas\Authentication\Storage\StorageInterface', $storage);
    }
}
