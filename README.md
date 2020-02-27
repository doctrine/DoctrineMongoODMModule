# Doctrine MongoDB ODM Module for Zend Framework 2

Master: [![Build Status](https://secure.travis-ci.org/doctrine/DoctrineMongoODMModule.png?branch=master)](http://travis-ci.org/doctrine/DoctrineMongoODMModule)

The DoctrineMongoODMModule integrates Doctrine 2 MongoDB ODM with Zend Framework 2
quickly and easily. The following features are intended to work out of the box:

  - MongoDB support
  - Multiple document managers
  - Multiple connections
  - Support for using existing `Mongo` connections
  - Doctrine Cli support

## Requirements
[Laminas MVC Skeleton Application](https://www.github.com/laminas/laminas-mvc-skeleton) (or compatible
architecture)

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](https://getcomposer.org/).

#### Installation steps

  1. `cd my/project/directory`
  2. create a `composer.json` file with following contents:

     ```json
     {
         "require": {
             "doctrine/doctrine-mongo-odm-module": "^1.0"
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
$dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
```

#### Configuration
##### Connection section

Either `server` or `connectionString` option has to be set.

| Name        | Default    |Description |
|-------------|------------|------------|
| server      |'localhost' | IP of mongod instance
| port        | 27017      | mongod port
| connectionString        | null      | If the connection string is specified, it will overwrite other connection options (`server`,`port`,`user`,`password`,`dbname`). Still, the connection will respect the settings passed in `options` array.
| user        | null        | If set, the client will try to authenticate with given username and password
| password    | null        | If set, the client will try to authenticate with given username and password
| dbname      | null        | If dbname is not specified, "admin" will be used for authentication. Also, specifiing dbname affecs the defaultDB configuration option, if that's not specified explicitly.
| options     | array()     | Array with connection options. More detailed description in http://www.php.net/manual/en/mongoclient.construct.php


Development
-----------

Unit tests rely on a mongo installation so all unit tests are ran through 
docker.  To run all unit tests execute:

```
docker-compose run --rm php composer test
```

Running unit tests with code coverage requires you build the docker
composer with XDEBUG=1

```
docker-compose build --build-arg XDEBUG=1
```

then run the unit tests as 

```
docker-compose run --rm php composer test-coverage
```
