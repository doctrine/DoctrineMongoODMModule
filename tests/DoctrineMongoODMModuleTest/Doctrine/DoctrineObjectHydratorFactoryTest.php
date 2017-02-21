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

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use PHPUnit_Framework_TestCase as TestCase;
use DoctrineMongoODMModule\Service\DoctrineObjectHydratorFactory;
use Zend\Hydrator\HydratorPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineObjectHydratorFactoryTest extends TestCase
{
    /** @var ServiceLocatorInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $services;

    protected function setUp()
    {
        parent::setUp();

        $this->services = $this->getMock(ServiceLocatorInterface::class);

        $this->services
            ->expects(self::once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->willReturn($this->prophesize(DocumentManager::class)->reveal());
    }

    public function testReturnsHydratorInstance()
    {
        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory($this->services, DoctrineObject::class);

        $this->assertInstanceOf(DoctrineObject::class, $hydrator);
    }

    public function testReturnsHydratorInstanceV2()
    {
        /** @var HydratorPluginManager $hydratorPluginManager */
        $hydratorPluginManager = $this->getMockBuilder(HydratorPluginManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hydratorPluginManager
            ->expects(self::once())
            ->method('getServiceLocator')
            ->willReturn($this->services);

        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory->createService($hydratorPluginManager);

        self::assertInstanceOf(DoctrineObject::class, $hydrator);
    }
}
