<?php

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Module;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Application;
use Zend\EventManager\Event;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    public function testOdmDefaultIsUsedAsTheDocumentManagerIfNoneIsProvided()
    {
        $documentManager = $this->getMockbuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManager = $this->getMock('Zend\ServiceManager\ServiceManager');
        $serviceManager->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.odm_default')
            ->will($this->returnValue($documentManager));

        $application = new Application();
        $event = new Event('loadCli.post', $application, array('ServiceManager' => $serviceManager));

        $module = new Module();
        $module->loadCli($event);

        $this->assertSame($documentManager, $application->getHelperSet()->get('documentManager')->getDocumentManager());
    }

    public function testDocumentManagerUsedCanBeSpecifiedInCommandLineArgument()
    {
        $argvBackup = $_SERVER['argv'];

        $documentManager = $this->getMockbuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManager = $this->getMock('Zend\ServiceManager\ServiceManager');
        $serviceManager->expects($this->once())
            ->method('get')
            ->with('doctrine.documentmanager.some_other_name')
            ->will($this->returnValue($documentManager));

        $application = new Application();
        $event = new Event('loadCli.post', $application, array('ServiceManager' => $serviceManager));

        $_SERVER['argv'][] = '--documentmanager=some_other_name';

        $module = new Module();
        $module->loadCli($event);

        $_SERVER['argv'] = $argvBackup;

        $this->assertSame($documentManager, $application->getHelperSet()->get('documentManager')->getDocumentManager());
    }
}
