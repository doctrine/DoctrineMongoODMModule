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
        $cursor          = $documentManager->getRepository(get_class(new Simple()))->findAll();

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

    public function testGetItemsReturnsACursor()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $cursor = $paginationAdapter->getItems(0, 1);

        $this->assertInstanceOf('Doctrine\ODM\MongoDB\Cursor', $cursor);
    }

    public function testGetItemsWithFirstFive()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $cursor = $paginationAdapter->getItems(0, 5);
        $documents = iterator_to_array($cursor, false);

        for ($i = 0; $i < 5; $i++) {
            $this->assertEquals(sprintf('Document %02d', $i + 1), $documents[$i]->getName());
        }

        $this->assertCount(5, $documents);
    }

    public function testGetItemsWithLastItem()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $cursor = $paginationAdapter->getItems($this->numberOfItems - 1, 5);
        $documents = iterator_to_array($cursor, false);

        $this->assertEquals(sprintf('Document %02d', $this->numberOfItems), $documents[0]->getName());
        $this->assertCount(1, $documents);
    }

    public function testGetItemsCalledTwoTimes()
    {
        $paginationAdapter = $this->getPaginationAdapter();

        $document1 = current(iterator_to_array($paginationAdapter->getItems(0, 1)));
        $document2 = current(iterator_to_array($paginationAdapter->getItems(1, 1)));

        $this->assertEquals('Document 01', $document1->getName());
        $this->assertEquals('Document 02', $document2->getName());
    }
}
