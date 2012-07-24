<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\Assets\Document\Simple;
use DoctrineMongoODMModuleTest\BaseTest;

class PersistTest extends BaseTest
{
    protected function alterConfig(array $config) {
        $config['doctrine']['driver']['test'] = array(
            'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(
                __DIR__ . '/../Assets/Document'
            )
        );
        $config['doctrine']['driver']['odm_default']['drivers']['DoctrineMongoODMModuleTest\Assets\Document'] = 'test';
        $config['doctrine']['configuration']['odm_default']['default_db'] = self::DEFAULT_DB;
        return $config;
    }

    public function testPersist(){

        $documentManager = $this->getDocumentManager();

        $simple = new Simple();
        $simple->setName('lucy');

        $documentManager->persist($simple);
        $documentManager->flush();
        $id = $simple->getId();

        $repository = $documentManager->getRepository(get_class($simple));
        $simple = $repository->find($id);

        $this->assertEquals('lucy', $simple->getName());
    }
}
