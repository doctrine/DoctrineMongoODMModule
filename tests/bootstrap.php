<?php

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('DoctrineMongoODMModuleTest', __DIR__);

Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

$config = require __DIR__ . '/test.application.config.php';

DoctrineMongoODMModuleTest\AbstractTest::setApplicationConfig($config);
