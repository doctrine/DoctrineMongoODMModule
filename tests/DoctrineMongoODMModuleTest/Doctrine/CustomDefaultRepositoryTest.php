<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;
use DoctrineMongoODMModuleTest\Assets\DefaultDocumentRepository;

final class CustomDefaultRepositoryTest extends AbstractTest
{
    public function testCustomDefaultRepository() : void
    {
        $documentManager = $this->getDocumentManager();

        $repository = $documentManager->getRepository(Simple::class);

        self::assertInstanceOf(DefaultDocumentRepository::class, $repository);
    }
}
