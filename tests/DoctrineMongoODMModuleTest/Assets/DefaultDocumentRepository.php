<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Assets;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class DefaultDocumentRepository extends DocumentRepository
{
    public function isCustomDefaultDocumentRepository()
    {
        return true;
    }
}
