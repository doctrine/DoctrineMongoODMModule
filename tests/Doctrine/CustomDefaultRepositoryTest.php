<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\CustomDocumentRepository;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;

use function assert;

final class CustomDefaultRepositoryTest extends AbstractTest
{
    public function testCustomDefaultRepository(): void
    {
        $documentManager = $this->getDocumentManager();

        $repository = $documentManager->getRepository(Simple::class);

        $this->assertInstanceOf(CustomDocumentRepository::class, $repository);
        assert($repository instanceof CustomDocumentRepository);
        $this->assertTrue($repository->isCustomDefaultDocumentRepository());
    }
}
