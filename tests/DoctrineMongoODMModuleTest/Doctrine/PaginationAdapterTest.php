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
            $this->assertEquals("Document $i", current($documents)->getName());
            next($documents);
        }

        $this->assertEquals(false, next($documents));
    }

    public function testGetLastItemAtOffsetNineteen()
    {
        $paginationAdapter = $this->getPaginationAdapter();

        $documents = $paginationAdapter->getItems($this->numberOfItems - 1, 5);

        $this->assertEquals('Document ' . $this->numberOfItems, current($documents)->getName());
        $this->assertEquals(false, next($documents));
    }

    public function testGetItemsCalledTwoTimes()
    {
        $paginationAdapter = $this->getPaginationAdapter();

        $items = $paginationAdapter->getItems(0, 5);

        $items2 = $paginationAdapter->getItems(2, 5);

        $this->assertNotEquals(current($items)->getName(), current($items2)->getName());
        $this->assertEquals('Document 1', current($items)->getName());
        $this->assertEquals('Document 3', current($items2)->getName());
    }
}
