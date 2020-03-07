<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationAdapterFactoryTest extends AbstractTest
{
    public function testAuthenticationAdapterFactory() : void
    {
        $adapter = $this->serviceManager->get('doctrine.authenticationadapter.odm_default');
        $this->assertInstanceOf('Laminas\Authentication\Adapter\AdapterInterface', $adapter);
    }
}
