<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationServiceFactoryTest extends AbstractTest
{
    public function testAuthenticationServiceFactory()
    {
        $authenticationService = $this->serviceManager->get('doctrine.authentication.service.default');

        $this->assertInstanceOf('Zend\Authentication\AuthenticationService', $authenticationService);
    }
}
