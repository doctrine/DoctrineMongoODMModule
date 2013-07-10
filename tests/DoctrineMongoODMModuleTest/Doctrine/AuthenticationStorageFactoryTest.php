<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationStorageFactoryTest extends AbstractTest
{
    public function testAuthenticationStorageFactory()
    {
        $this->assertInstanceOf(
            'Zend\Authentication\Storage\StorageInterface',
            $this->serviceManager->get('doctrine.authentication.storage.default')
        );
    }
}
