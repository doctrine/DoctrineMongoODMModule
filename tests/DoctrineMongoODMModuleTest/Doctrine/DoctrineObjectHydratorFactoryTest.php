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

use DoctrineMongoODMModule\Service\DoctrineObjectHydratorFactory;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

final class DoctrineObjectHydratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsHydratorInstance()
    {
        $serviceLocatorInterface = $this->getMockBuilder('Zend\ServiceManager\ServiceLocatorInterface')->getMock();

        $serviceLocatorInterface
            ->expects(self::once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->willReturn(
                $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
                     ->disableOriginalConstructor()
                     ->getMock()
            );

        /** @var HydratorPluginManager|\PHPUnit_Framework_MockObject_MockObject $hydratorPluginManager */
        $hydratorPluginManager = $this->getMockBuilder('Zend\Stdlib\Hydrator\HydratorPluginManager')->getMock();

        $hydratorPluginManager
            ->expects(self::once())
            ->method('getServiceLocator')
            ->willReturn(
                $serviceLocatorInterface
            );


        $factory  = new DoctrineObjectHydratorFactory();
        $hydrator = $factory($hydratorPluginManager);

        self::assertInstanceOf('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $hydrator);
    }
}
