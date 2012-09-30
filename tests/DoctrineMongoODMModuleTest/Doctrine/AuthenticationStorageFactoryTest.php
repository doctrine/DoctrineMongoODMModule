<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;
use Zend\Authentication\Storage\StorageInterface;

class AuthenticationStorageFactoryTest extends AbstractTest
{
    public function testAuthenticationStorageFactory(){

        $storage = $this->serviceManager->get('doctrine.authenticationstorage.odm_default');
        $this->assertTrue($storage instanceof StorageInterface);
    }
}
