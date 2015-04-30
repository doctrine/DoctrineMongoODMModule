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
use Zend\Paginator\Paginator;

/**
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Chris Levy <chrisianlevy@yahoo.co.uk>
 *
 * @covers \DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator
 */
class PaginationTest extends AbstractTest
{
    protected function getPaginationAdapter()
    {
        $documentManager = $this->getDocumentManager();

        $cursor = $documentManager->createQueryBuilder(get_class(new Simple()))->getQuery()->execute();
        $cursor->sort(array('Name', 'asc'));

        return new DoctrinePaginator($cursor);
    }

    protected function getPaginator(DoctrinePaginator $adapter)
    {
        return new Paginator($adapter);
    }

    public function setUp()
    {
        parent::setUp();

        $documentManager = $this->getDocumentManager();

        for ($i = 1; $i <= 20; $i++) {
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
