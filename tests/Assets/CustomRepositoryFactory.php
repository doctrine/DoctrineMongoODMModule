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
            public function find($id): ?object
            {
                return null;
            }

            /**
             * {@inheritDoc}
             *
             * @psalm-return mixed[]
             */
            public function findAll(): array
            {
                return [];
            }

            /**
             * {@inheritDoc}
             *
             * @psalm-return mixed[]
             */
            public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
            {
                return [];
            }

            /**
             * {@inheritDoc}
             */
            public function findOneBy(array $criteria): ?object
            {
                return null;
            }

            public function getClassName(): string
            {
                return '';
            }
        };
    }
}
