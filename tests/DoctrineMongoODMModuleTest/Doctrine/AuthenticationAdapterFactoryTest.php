<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationAdapterFactoryTest extends AbstractTest
{
    public function testAuthenticationAdapterFactory()
    {
        $this->assertInstanceOf(
            'Zend\Authentication\Adapter\AdapterInterface',
            $this->serviceManager->get('doctrine.authenticationadapter.odm_default')
        );
    }
}
