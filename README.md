# Doctrine MongoDB Module for Zend Framework 2
The DoctrineMongoODMModule integrates Doctrine 2 MongoDB ODM with Zend Framework 2 
quickly and easily. The following features are intended to work out of the box: 
  
  - MongoDB support
  - Multiple document managers
  - Multiple connections
  - Support for using existing Mongo connections
  
Also provides an Auth Adapter.

## Requirements
  - [DoctrineModule](http://www.github.com/doctrine/DoctrineModule)
  - [Zend Framework 2](http://www.github.com/zendframework/zf2)

## Doctrine CLI
The Doctrine CLI has been pre-configured and is available in DoctrineModule\bin. It should work as
is without any special configuration required.

## Auth Adapter
Example DI config to prepare the Auth Adapter for use:

    'DoctrineMongoODMModule\Authentication\Adapter\DoctrineDocument' => array(
        'parameters' => array(
            'documentManager' => 'mongo_dm',
            'document' => 'Application\Model\User',
            'identityField' => 'username',
            'credentialField' => 'password',
            'credentialCallable' => 'Application\Model\User::checkPassword'
        )
    ),
            
## Installation
See the [INSTALL.md](http://www.github.com/doctrine/DoctrineMongoODMModule/tree/master/docs/INSTALL.md) file.

## TODO
See the [TODO.md](http://www.github.com/doctrine/DoctrineMongoODMModule/tree/master/docs/TODO.md) file.