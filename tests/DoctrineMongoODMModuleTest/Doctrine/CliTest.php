<?php
/* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
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

use Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateDocumentsCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\GeneratePersistentCollectionsCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateRepositoriesCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\QueryCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand;
use Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\UpdateCommand;

/**
 * Tests used to verify that command line functionality is active
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Adam Homsi <adam.homsi@gmail.com>
 */
final class CliTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Console\Application
     */
    protected $cli;

    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $documentManager;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $serviceManager     = \DoctrineMongoODMModuleTest\Doctrine\Util\ServiceManagerFactory::getServiceManager();

        /* @var $application \Zend\Mvc\Application */
        $application        = $serviceManager->get('Application');
        $invocations        = 0;

        $application->getEventManager()->getSharedManager()->attach(
            'doctrine',
            'loadCli.post',
            function () use (&$invocations) {
                ++$invocations;
            }
        );

        $application->bootstrap();
        $this->documentManager = $serviceManager->get('doctrine.documentmanager.odm_default');
        $this->cli           = $serviceManager->get('doctrine.cli');

        $this->assertSame(1, $invocations);
    }

    public function testValidHelpers()
    {
        $helperSet = $this->cli->getHelperSet();

        /* @var $dmHelper \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper */
        $dmHelper = $helperSet->get('dm');

        $this->assertInstanceOf('\Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper', $dmHelper);
        $this->assertSame($this->documentManager, $dmHelper->getDocumentManager());
    }

    public function testValidCommands()
    {
        self::assertInstanceOf(GenerateDocumentsCommand::class, $this->cli->get('odm:generate:documents'));
        self::assertInstanceOf(GenerateHydratorsCommand::class, $this->cli->get('odm:generate:hydrators'));
        self::assertInstanceOf(GenerateProxiesCommand::class, $this->cli->get('odm:generate:proxies'));
        self::assertInstanceOf(GenerateRepositoriesCommand::class, $this->cli->get('odm:generate:repositories'));
        self::assertInstanceOf(
            GeneratePersistentCollectionsCommand::class,
            $this->cli->get('odm:generate:persistent-collections')
        );
        self::assertInstanceOf(QueryCommand::class, $this->cli->get('odm:query'));
        self::assertInstanceOf(CreateCommand::class, $this->cli->get('odm:schema:create'));
        self::assertInstanceOf(UpdateCommand::class, $this->cli->get('odm:schema:update'));
        self::assertInstanceOf(DropCommand::class, $this->cli->get('odm:schema:drop'));
    }
}
