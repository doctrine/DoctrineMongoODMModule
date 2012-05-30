# Installing the Doctrine MongoDB module for Zend Framework 2 
Doctrine MongoDB uses Composer to install. If you have not set up composer, 
please see the detailed instructions in the DoctrineModule readme.

Add the following to your project's composer.json file.
    "require": {
        "doctrine/DoctrineMongoODMModule": "dev-master",  
    }

Finally, run `composer.phar install` in your project directory.

##Config

Open `my/project/directory/configs/application.config.php` and add `DoctrineMongoODMModule` to your `modules`

Drop `vendor/doctrine/DoctrineMongoODMModule/config/module.doctrine_mongodb.local.php.dist` into your application's
     `config/autoload` directory, rename it to `module.doctrine_mongodb.local.php` and make the appropriate changes.

Create directory `my/project/directory/data/DoctrineMongoODMModule/Proxy` and 
`my/project/directory/data/DoctrineMongoODMModule/Hydrator`and make sure your application has write access to it.
    
## Registering drivers with the DriverChain

To register drivers with the driver chain simply include the following snippet in your Module's init() method.

```php
$sharedEvents = $mm->events()->getSharedManager();
$sharedEvents->attach('DoctrineMongoODMModule', 'loadDrivers', function($e) {
    return array(
        'Module\Entity' => $e->getParam('config')->newDefaultAnnotationDriver(__DIR__ . '/src/Module/Entity')
    );
});
```

## Registering subscribers with the EventManager

To register subscribers with the EventManager, add the following snippet in your Module's init() method.

```php
$sharedEvents = $mm->events()->getSharedManager();
$sharedEvents->attach('DoctrineMongoODMModule', 'loadSubscribers', function($e) {
    return array(
        My\Subscriber
    );
});
```

## Usage
Access the document manager through the ServiceManager. 

    $em = $serviceManager()->get('mongo_dm');

## Command Line
Access the Doctrine command line as following

```sh
./vendor/bin/doctrine-module
```