<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;

/**
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Roman Konz <roman@konz.me>
 *
 * @covers \DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator
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

        $cursor = $documentManager->createQueryBuilder(get_class(new Simple()))->getQuery()->execute();
        $cursor->sort(array('name' => 'asc'));

        return new DoctrinePaginator($cursor);
    }

    public function setup()
    {
        parent::setup();

        $this->numberOfItems = 20;
        $documentManager     = $this->getDocumentManager();

        for ($i = 1; $i <= $this->numberOfItems; $i++) {
            $document = new Simple();
            $document->setName(sprintf('Document %02d', $i));
            $documentManager->persist($document);
        }
        $documentManager->flush();
    }

    public function testItemCount()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $this->assertEquals($this->numberOfItems, $paginationAdapter->count());
    }

    public function testGetItemsWithFirstFive()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $documents = $paginationAdapter->getItems(0, 5);

        $this->assertCount(5, $documents);
        for ($i = 1; $i <= 5; $i++) {
            $this->assertEquals(sprintf('Document %02d', $i), current($documents)->getName());
            next($documents);
        }
    }

    public function testGetItemsWithLastItem()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $documents = $paginationAdapter->getItems($this->numberOfItems - 1, 5);

        $this->assertEquals(sprintf('Document %02d', $this->numberOfItems), current($documents)->getName());
        $this->assertCount(1, $documents);
    }

    public function testGetItemsCalledTwoTimes()
    {
        $paginationAdapter = $this->getPaginationAdapter();

        $document1 = current($paginationAdapter->getItems(0, 1));
        $document2 = current($paginationAdapter->getItems(1, 1));

        $this->assertEquals('Document 01', $document1->getName());
        $this->assertEquals('Document 02', $document2->getName());
    }

    public function testItemsAreKeyedAsSequentialIntegers()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $items = $paginationAdapter->getItems(0, $paginationAdapter->count());

        for ($i = 0; $i < $paginationAdapter->count(); $i++) {
            $this->assertArrayHasKey($i, $items);
        }
    }
}
