<?php
namespace DoctrineMongoODMModuleTest\Assets;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\RepositoryFactory;

/**
 * Class CustomRepositoryFactory
 * @package DoctrineMongoODMModuleTest\Assets
 */
class CustomRepositoryFactory implements RepositoryFactory
{
    /**
     * Stub.
     *
     * @param DocumentManager $documentManager The DocumentManager instance.
     * @param string $documentName The name of the document.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(DocumentManager $documentManager, $documentName)
    {
    }
}
