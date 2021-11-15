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
        return new class () implements ObjectRepository {
            /**
             * {@inheritDoc}
             */
            public function find($id)
            {
                return null;
            }

            /**
             * {@inheritDoc}
             */
            public function findAll()
            {
                return [];
            }

            /**
             * {@inheritDoc}
             */
            public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
            {
                return [];
            }

            /**
             * {@inheritDoc}
             */
            public function findOneBy(array $criteria)
            {
                return null;
            }

            /**
             * {@inheritDoc}
             */
            public function getClassName()
            {
                return '';
            }
        };
    }
}
