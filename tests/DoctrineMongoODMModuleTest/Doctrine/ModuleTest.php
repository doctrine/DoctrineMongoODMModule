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

use DoctrineMongoODMModule\Module;
use Symfony\Component\Console\Application;
use Zend\EventManager\Event;

final class ModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testOdmDefaultIsUsedAsTheDocumentManagerIfNoneIsProvided()
    {
        $documentManager = $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')->getMock();
        $serviceManager->expects(self::once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->will(self::returnValue($documentManager));

        $application = new Application();
        $event = new Event('loadCli.post', $application, ['ServiceManager' => $serviceManager]);

        $module = new Module();
        $module->loadCli($event);

        self::assertSame($documentManager, $application->getHelperSet()->get('documentManager')->getDocumentManager());
    }

    public function testDocumentManagerUsedCanBeSpecifiedInCommandLineArgument()
    {
        $argvBackup = $_SERVER['argv'];

        $documentManager = $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')->getMock();
        $serviceManager->expects(self::once())
            ->method('get')
            ->with('doctrine.documentmanager.some_other_name')
            ->will(self::returnValue($documentManager));

        $application = new Application();
        $event = new Event('loadCli.post', $application, ['ServiceManager' => $serviceManager]);

        $_SERVER['argv'][] = '--documentmanager=some_other_name';

        $module = new Module();
        $module->loadCli($event);

        $_SERVER['argv'] = $argvBackup;

        self::assertSame($documentManager, $application->getHelperSet()->get('documentManager')->getDocumentManager());
    }
}
