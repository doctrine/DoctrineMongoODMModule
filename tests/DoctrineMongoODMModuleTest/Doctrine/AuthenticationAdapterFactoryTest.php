<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;
use Zend\Authentication\Adapter\AdapterInterface;

class AuthenticationAdapterFactoryTest extends AbstractTest
{
    public function testAuthenticationAdapterFactory(){

        $adapter = $this->serviceManager->get('doctrine.authenticationadapter.odm_default');
        $this->assertTrue($adapter instanceof AdapterInterface);
    }
}
