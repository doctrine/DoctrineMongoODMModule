<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationServiceFactoryTest extends AbstractTest
{
    public function testAuthenticationServiceFactory(): void
    {
        $authenticationService = $this->serviceManager->get('doctrine.authenticationservice.odm_default');
        $this->assertInstanceOf('Laminas\Authentication\AuthenticationService', $authenticationService);
    }
}
