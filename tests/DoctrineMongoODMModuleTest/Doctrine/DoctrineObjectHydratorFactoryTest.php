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

use PHPUnit_Framework_TestCase as TestCase;
use DoctrineMongoODMModule\Service\DoctrineObjectHydratorFactory;
use Zend\Hydrator\HydratorPluginManager;

class DoctrineObjectHydratorFactoryTest extends TestCase
{
    /**
     * @group broken
     */
    public function testReturnsHydratorInstance()
    {
        $serviceLocatorInterface = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $serviceLocatorInterface
            ->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->willReturn(
                $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
                     ->disableOriginalConstructor()
                     ->getMock()
            );

        /** @var HydratorPluginManager $hydratorPluginManager */
        $hydratorPluginManager = $this->getMockBuilder('Zend\Hydrator\HydratorPluginManager')
                                      ->disableOriginalConstructor()
                                      ->getMock();

        $hydratorPluginManager
            ->expects($this->once())
            ->method('getServiceLocator')
            ->willReturn(
                $serviceLocatorInterface
            );

        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory($hydratorPluginManager);

        $this->assertInstanceOf('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $hydrator);
    }
}
