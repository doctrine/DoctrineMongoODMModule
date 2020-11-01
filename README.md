# Doctrine MongoDB ODM Module for Laminas

[![Build Status](https://secure.travis-ci.org/doctrine/DoctrineMongoODMModule.png?branch=3.0.x)](http://travis-ci.org/doctrine/DoctrineMongoODMModule)
[![Coverage Status](https://coveralls.io/repos/github/doctrine/DoctrineMongoODMModule/badge.svg?branch=3.0.x)](https://coveralls.io/github/doctrine/DoctrineMongoODMModule?branch=3.0.x)
[![Latest Stable Version](https://poser.pugx.org/doctrine/doctrine-mongo-odm-module/v/stable.png)](https://packagist.org/packages/doctrine/doctrine-mongo-odm-module) 
[![Total Downloads](https://poser.pugx.org/doctrine/doctrine-mongo-odm-module/downloads.png)](https://packagist.org/packages/doctrine/doctrine-mongo-odm-module)

The DoctrineMongoODMModule integrates Doctrine 2 MongoDB ODM with Laminas
quickly and easily. The following features are intended to work out of the box:

  - MongoDB support
  - Multiple document managers
  - Multiple connections
  - Support for using existing `Mongo` connections
  - Doctrine CLI support

## Requirements

[Laminas MVC Skeleton Application](https://www.github.com/laminas/laminas-mvc-skeleton) (or compatible
architecture)

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
composer require doctrine/doctrine-mongo-odm-module
```

Copy `vendor/doctrine/doctrine-mongo-odm-module/config/module.doctrine-mongo-odm.local.php.dist` into your application's
`config/autoload` directory, rename it to `module.doctrine-mongo-odm.local.php`, and make the appropriate changes.
With this config file you can configure your mongo connection, add extra annotations to register, add subscribers to
the event manager, add filters to the filter collection, and drivers to the driver chain.

Then add `DoctrineModule` and `DoctrineMongoODMModule` to your `config/application.config.php` and create directories
`data/DoctrineMongoODMModule/Proxy` and `data/DoctrineMongoODMModule/Hydrator` and make sure your application has 
write access to them.

Installation without composer is not officially supported and requires you to manually install all dependencies
that are listed in `composer.json`


## Usage

#### Command Line
Access the Doctrine command line as following

```sh
php public/index.php
```
or
```sh
./vendor/bin/doctrine-module
```

#### Service Locator
Access the document manager using this service manager alias:

```php
$dm = $serviceManager->get('doctrine.documentmanager.odm_default');
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

To change docker to a different php version

```
docker-compose build --build-arg PHP_VERSION=7.3
```

then run the unit tests as 

```
docker-compose run --rm php composer test-coverage
```

Run phpcs as 
```
docker-compose run --rm php composer cs-check src test config
```

