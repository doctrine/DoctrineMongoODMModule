<?php
$applicationRoot = __DIR__ . '/../../../../';

chdir($applicationRoot);

$loader = require_once('vendor/autoload.php');
$loader->add('DoctrineMongoODMModuleTest', __DIR__);

$config = include(__DIR__ . '/test.application.config.php');


\DoctrineMongoODMModuleTest\Doctrine\Util\ServiceManagerFactory::setConfig($config);
\DoctrineMongoODMModuleTest\AbstractTest::setApplicationConfig($config);
