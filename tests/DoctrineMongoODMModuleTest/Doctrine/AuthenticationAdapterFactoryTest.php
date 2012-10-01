<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationAdapterFactoryTest extends AbstractTest
{
    public function testAuthenticationAdapterFactory(){

        $adapter = $this->serviceManager->get('doctrine.authenticationadapter.odm_default');
        $this->assertInstanceOf('Zend\Authentication\Adapter\AdapterInterface', $adapter);
    }
}
