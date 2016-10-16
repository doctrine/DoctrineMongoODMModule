<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */
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
        $cursor->sort(['name' => 'asc']);

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

    public function testItemCountWithEagerCursor()
    {
        $documentManager = $this->getDocumentManager();

        // Prepare an adapter with a limit already set. EagerCursors don't support $foundOnly = false
        $cursor = $documentManager->createQueryBuilder(Simple::class)->eagerCursor(true)->getQuery()->execute();
        $cursor->sort(['name' => 'asc'])->limit(5);

        $paginationAdapter = new DoctrinePaginator($cursor);

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
