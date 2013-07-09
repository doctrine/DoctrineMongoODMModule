<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use Zend\Paginator\Paginator;
use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineMongoODMModuleTest\AbstractTest;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;

/**
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Chris Levy <chrisianlevy@yahoo.co.uk>
 */
class PaginationTest extends AbstractTest
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
    
    protected function getPaginator(DoctrinePaginator $adaptor)
    {
        return new Paginator($adaptor);
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

    public function testGetFoundItemCount()
    {
        $paginationAdapter = $this->getPaginationAdapter();
        $paginator = $this->getPaginator($paginationAdapter);
        $pages = $paginator->getPages();
        
        $this->assertEquals(10, $pages->lastItemNumber);
    }
}
