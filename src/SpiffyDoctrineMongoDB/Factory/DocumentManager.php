<?php
namespace SpiffyDoctrineMongoODM\Factory;
use Doctrine\Common\Annotations\AnnotationRegistry,
    Doctrine\ODM\MongoDB\DocumentManager as MongoDocumentManager,
    SpiffyDoctrineMongoODM\Doctrine\ODM\MongoDB\Connection;

class DocumentManager
{
    public static function get(Connection $conn)
    {
        return MongoDocumentManager::create(
            $conn->getInstance(),
            $conn->getInstance()->getConfiguration(),
            $conn->getInstance()->getEventManager()
        );
    }
}