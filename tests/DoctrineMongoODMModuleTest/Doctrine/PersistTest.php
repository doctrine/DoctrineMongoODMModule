<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\Assets\Document\Simple;
use DoctrineMongoODMModuleTest\AbstractTest;

class PersistTest extends AbstractTest
{
    public function testPersist()
    {
        $documentManager = $this->getDocumentManager();
        $simple          = new Simple();

        $simple->setName('lucy');
        $documentManager->persist($simple);
        $documentManager->flush();

        $id         = $simple->getId();
        $repository = $documentManager->getRepository(get_class($simple));
        $simple     = $repository->find($id);

        $this->assertEquals('lucy', $simple->getName());
    }
}
