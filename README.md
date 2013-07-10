# Doctrine MongoDB ODM Module for Zend Framework 2

Master: [![Build Status](https://secure.travis-ci.org/doctrine/DoctrineMongoODMModule.png?branch=master)](http://travis-ci.org/doctrine/DoctrineMongoODMModule)

The DoctrineMongoODMModule integrates Doctrine 2 MongoDB ODM with Zend Framework 2
quickly and easily. The following features are intended to work out of the box:

  - MongoDB support
  - Multiple document managers
  - Multiple connections
  - Support for using existing `Mongo` connections

## Requirements
[Zend Framework 2 Application Skeleton](http://www.github.com/zendframework/ZendSkeletonApplication) (or compatible
architecture)

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

#### Installation steps

  1. `cd my/project/directory`
  2. create a `composer.json` file with following contents:

     ```json
     {
         "minimum-stability": "alpha",
         "require": {
             "doctrine/doctrine-mongo-odm-module": "dev-master"
         }
     }
     ```
  3. install composer via `curl -s http://getcomposer.org/installer | php` (on windows, download
     http://getcomposer.org/installer and execute it with PHP)
  4. run `php composer.phar install`
  5. open `my/project/directory/configs/application.config.php` and add following keys to your `modules` (in this order)

     ```php
     'DoctrineModule',
     'DoctrineMongoODMModule',
     ```

  6. copy `vendor/doctrine/doctrine-mongo-odm-module/config/module.doctrine-mongo-odm.local.php.dist` into your application's
     `config/autoload` directory, rename it to `module.doctrine-mongo-odm.local.php` and make the appropriate changes.
     With this config file you can configure your mongo connection, add extra annotations to register, add subscribers to
     the event manager, add filters to the filter collection, and drivers to the driver chain.

  7. create directory `my/project/directory/data/DoctrineMongoODMModule/Proxy` and
     `my/project/directory/data/DoctrineMongoODMModule/Hydrator` and make sure your application has write access to it.

## Usage

#### Command Line
Access the Doctrine command line as following

```sh
./vendor/bin/doctrine-module
```

#### Service Locator
Access the document manager using the following service manager alias:

```php
<?php
$dm = $this->getServiceLocator()->get('doctrine.odm.documentmanager.default');
```
