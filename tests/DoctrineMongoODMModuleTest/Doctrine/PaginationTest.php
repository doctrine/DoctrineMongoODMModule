<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;
use Laminas\Paginator\Paginator;
use function get_class;

/**
 * @link    http://www.doctrine-project.org/
 *
 * @covers \DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator
 */
class PaginationTest extends AbstractTest
{
    protected function getPaginationAdapter() : DoctrinePaginator
    {
        $documentManager = $this->getDocumentManager();

        $cursor = $documentManager->createQueryBuilder(get_class(new Simple()))->getQuery()->execute();
        $cursor->sort(['Name', 'asc']);

        return new DoctrinePaginator($cursor);
    }

    protected function getPaginator(DoctrinePaginator $adapter) : Paginator
    {
        return new Paginator($adapter);
    }

    protected function setUp() : void
    {
        parent::setUp();

        $documentManager = $this->getDocumentManager();

        for ($i = 1; $i <= 20; $i++) {
            $document = new Simple();
            $document->setName('Document ' . $i);
            $documentManager->persist($document);
        }

        $documentManager->flush();
    }

    public function testGetFoundItemCount() : void
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $paginator         = $this->getPaginator($paginationAdapter);
        $pages             = $paginator->getPages();

        $this->assertEquals(10, $pages->lastItemNumber);
    }
}
