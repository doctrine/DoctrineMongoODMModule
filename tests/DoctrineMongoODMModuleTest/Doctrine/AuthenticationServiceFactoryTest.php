<?php
namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationServiceFactoryTest extends AbstractTest
{
    public function testAuthenticationServiceFactory()
    {
        $authenticationService = $this->serviceManager->get('doctrine.authenticationservice.odm_default');
        $this->assertInstanceOf('Laminas\Authentication\AuthenticationService', $authenticationService);
    }
}
