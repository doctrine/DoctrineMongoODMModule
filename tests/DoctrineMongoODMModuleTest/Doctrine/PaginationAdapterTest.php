<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;

/**
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Roman Konz <roman@konz.me>
 */
class PaginationAdapterTest extends AbstractTest
{
    /**
     * number of items generated in tests
     *
     * @var int
     */
    protected $numberOfItems;

    protected function getPaginationAdapter()
    {
        $documentManager = $this->getDocumentManager();

        $cursor = $documentManager->getRepository(get_class(new Simple()))->findAll();
        $cursor->sort(array('Name', 'asc'));

        return new DoctrinePaginator($cursor);
    }

    public function setup()
    {
        parent::setup();

        $this->numberOfItems = 20;
        $documentManager     = $this->getDocumentManager();

        for ($i = 1; $i <= $this->numberOfItems; $i++) {
            $document = new Simple();
            $document->setName("Document $i");
            $documentManager->persist($document);
        }
        $documentManager->flush();
    }

    public function testItemCount()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $this->assertEquals($this->numberOfItems, $paginationAdapter->count());
    }

    public function testGetFiveItemsAtOffsetZero()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $documents         = $paginationAdapter->getItems(0, 5);

        for ($i = 1; $i <= 5; $i++) {
            $documents->next();
            $this->assertEquals("Document $i", $documents->current()->getName());
        }

        $this->assertNull($documents->next());
    }

    public function testGetLastItemAtOffsetNineteen()
    {
        $paginationAdapter = $this->getPaginationAdapter();

        $documents = $paginationAdapter->getItems($this->numberOfItems - 1, 5);
        $documents->next();

        $this->assertEquals('Document ' . $this->numberOfItems, $documents->current()->getName());
        $this->assertNull($documents->next());
    }

    public function testGetItemsCalledTwoTimes()
    {
        $paginationAdapter = $this->getPaginationAdapter();

        $items = $paginationAdapter->getItems(0, 5);
        $items->next();

        $items2 = $paginationAdapter->getItems(2, 5);
        $items2->next();

        $this->assertNotEquals($items->current()->getName(), $items2->current()->getName());
        $this->assertEquals('Document 1', $items->current()->getName());
        $this->assertEquals('Document 3', $items2->current()->getName());
    }
}
