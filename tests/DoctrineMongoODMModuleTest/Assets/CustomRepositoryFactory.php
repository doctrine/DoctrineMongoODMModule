<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Assets;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\RepositoryFactory;
use Doctrine\Persistence\ObjectRepository;

class CustomRepositoryFactory implements RepositoryFactory
{
    /**
     * Stub.
     *
     * @param DocumentManager $documentManager The DocumentManager instance.
     * @param string          $documentName    The name of the document.
     */
    public function getRepository(DocumentManager $documentManager, string $documentName): ObjectRepository
    {
    }
}
