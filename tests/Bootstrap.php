<?php
chdir(dirname(__DIR__));

$loader = require_once('vendor/autoload.php');

$config = include(__DIR__ . '/test.application.config.php');

\DoctrineMongoODMModuleTest\Doctrine\Util\ServiceManagerFactory::setConfig($config);
\DoctrineMongoODMModuleTest\AbstractTest::setApplicationConfig($config);
