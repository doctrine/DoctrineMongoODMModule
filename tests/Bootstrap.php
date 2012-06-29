<?php
chdir(__DIR__);

$previousDir = '.';
while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());
    if($previousDir === $dir) {
        throw new RuntimeException(
            'Unable to locate "config/application.config.php": ' .
            'is DoctrineORMModule in a subdir of your application skeleton?'
        );
    }
    $previousDir = $dir;
    chdir($dir);
}

require_once('vendor/autoload.php');

if (is_readable(__DIR__ . '/TestConfiguration.php')) {
    require_once __DIR__ . '/TestConfiguration.php';
} else {
    require_once __DIR__ . '/TestConfiguration.php.dist';
}

\DoctrineMongoODMModuleTest\BaseTest::setMvcConfig($configuration);