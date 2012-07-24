<?php

use Zend\Loader\StandardAutoloader;
use DoctrineMongoODMModuleTest\BaseTest;

chdir(__DIR__);

$previousDir = '.';

while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());

    if($previousDir === $dir) {
        throw new RuntimeException(
            'Unable to locate "config/application.config.php": ' .
            'is DoctrineMongoODMModuleTest in a subdir of your application skeleton?'
        );
    }

    $previousDir = $dir;
    chdir($dir);
}

if (!(@include_once __DIR__ . '/../vendor/autoload.php') && !(@include_once __DIR__ . '/../../../autoload.php')) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

if (!$config = @include __DIR__ . '/TestConfiguration.php') {
    $config = require __DIR__ . '/TestConfiguration.php.dist';
}

$loader = new StandardAutoloader(array(
    StandardAutoloader::LOAD_NS => array(
        'DoctrineMongoODMModuleTest' => __DIR__ . '/DoctrineMongoODMModuleTest',
    ),
));
$loader->register();

if (!$config = @include __DIR__ . '/TestConfiguration.php') {
    $config = require __DIR__ . '/TestConfiguration.php.dist';
}

BaseTest::setMvcConfig($config);