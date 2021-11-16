<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper;
use DoctrineMongoODMModule\Module;
use Laminas\EventManager\Event;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

use function assert;

class ModuleTest extends TestCase
{
    public function testOdmDefaultIsUsedAsTheDocumentManagerIfNoneIsProvided(): void
    {
        $documentManager = $this->getMockbuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManager = $this->createMock('Laminas\ServiceManager\ServiceManager');
        $serviceManager->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->will($this->returnValue($documentManager));

        $application = new Application();
        $event       = new Event('loadCli.post', $application, ['ServiceManager' => $serviceManager]);

        $module = new Module();
        $module->loadCli($event);

        $documentManagerHelper = $application->getHelperSet()->get('documentManager');
        assert($documentManagerHelper instanceof DocumentManagerHelper);
        $this->assertSame($documentManager, $documentManagerHelper->getDocumentManager());
    }

    public function testDocumentManagerUsedCanBeSpecifiedInCommandLineArgument(): void
    {
        $argvBackup = $_SERVER['argv'];

        $documentManager = $this->getMockbuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManager = $this->createMock('Laminas\ServiceManager\ServiceManager');
        $serviceManager->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.some_other_name')
            ->will($this->returnValue($documentManager));

        $application = new Application();
        $event       = new Event('loadCli.post', $application, ['ServiceManager' => $serviceManager]);

        $_SERVER['argv'][] = '--documentmanager=some_other_name';

        $module = new Module();
        $module->loadCli($event);

        $_SERVER['argv'] = $argvBackup;

        $documentManagerHelper = $application->getHelperSet()->get('documentManager');
        assert($documentManagerHelper instanceof DocumentManagerHelper);
        $this->assertSame($documentManager, $documentManagerHelper->getDocumentManager());
    }
}
