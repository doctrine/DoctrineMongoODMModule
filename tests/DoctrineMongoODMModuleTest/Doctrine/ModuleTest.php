<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Module;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Application;
use Zend\EventManager\Event;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    protected function getMockServiceManager()
    {
        $serviceManager = $this->getMock('Zend\ServiceManager\ServiceManager');

        $commandNames = array(
            'doctrine.odm.query_command',
            'doctrine.odm.generate_documents_command',
            'doctrine.odm.generate_repositories_command',
            'doctrine.odm.generate_proxies_command',
            'doctrine.odm.generate_hydrators_command',
            'doctrine.odm.create_command',
            'doctrine.odm.update_command',
            'doctrine.odm.drop_command',
            'doctrine.odm.clear_cache_metadata'
        );

        $i = 0;

        $definition = $this->getMock('Symfony\Component\Console\Input\InputDefinition');
        $definition->expects($this->any())
            ->method('addOption');

        $command = $this->getMockbuilder('Symfony\Component\Console\Command\Command')
            ->disableOriginalConstructor()
            ->getMock();

        $command->expects($this->any())
            ->method('getDefinition')
            ->will($this->returnValue($definition));

        foreach ($commandNames as $commandName) {
            $serviceManager->expects($this->at($i))
                ->method('get')
                ->with($commandName)
                ->will($this->returnValue($command));
            $i++;
        }

        return array($serviceManager, $i);
    }

    public function testOdmDefaultIsUsedAsTheDocumentManagerIfNoneIsProvided()
    {
        $documentManager = $this->getMockbuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        list($serviceManager, $i) = $this->getMockServiceManager();
        $serviceManager->expects($this->at($i))
            ->method('get')
            ->with('doctrine.odm.documentmanager.default')
            ->will($this->returnValue($documentManager));

        $application = new Application();
        $event = new Event('loadCli.post', $application, array('ServiceManager' => $serviceManager));

        $module = new Module();
        $module->initializeConsole($event);

        $this->assertSame($documentManager, $application->getHelperSet()->get('documentManager')->getDocumentManager());
    }

    public function testDocumentManagerUsedCanBeSpecifiedInCommandLineArgument()
    {
        $argvBackup = $_SERVER['argv'];

        $documentManager = $this->getMockbuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        list($serviceManager, $i) = $this->getMockServiceManager();
        $serviceManager->expects($this->at($i))
            ->method('get')
            ->with('doctrine.odm.documentmanager.some_other_name')
            ->will($this->returnValue($documentManager));

        $application = new Application();
        $event = new Event('loadCli.post', $application, array('ServiceManager' => $serviceManager));

        $_SERVER['argv'][] = '--documentmanager=some_other_name';

        $module = new Module();
        $module->initializeConsole($event);

        $_SERVER['argv'] = $argvBackup;

        $this->assertSame($documentManager, $application->getHelperSet()->get('documentManager')->getDocumentManager());
    }
}
