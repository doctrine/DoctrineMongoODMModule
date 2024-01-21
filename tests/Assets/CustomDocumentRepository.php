<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Assets;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class CustomDocumentRepository extends DocumentRepository
{
    public function isCustomDefaultDocumentRepository(): bool
    {
        return true;
    }
}
