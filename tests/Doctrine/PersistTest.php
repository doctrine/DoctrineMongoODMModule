<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;

use function get_class;

class PersistTest extends AbstractTest
{
    public function testPersist(): void
    {
        $documentManager = $this->getDocumentManager();

        $simple = new Simple();
        $simple->setName('lucy');

        $documentManager->persist($simple);
        $documentManager->flush();
        $id = $simple->getId();

        $repository = $documentManager->getRepository(get_class($simple));
        $simple     = $repository->find($id);

        self::assertEquals('lucy', $simple->getName());
    }
}
