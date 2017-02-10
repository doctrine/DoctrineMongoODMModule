User Guide
==========

This guide helps you to create a Zend Framework 2 application with Doctrine Mongo ODM integration. If you're new to Zend
Framework 2, please read the [ZF2 user guide](http://framework.zend.com/manual/2.3/en/user-guide/overview.html) before you 
continue.

Install Composer
----------------
install composer via `curl -s http://getcomposer.org/installer | php` 
(on windows, download http://getcomposer.org/installer and execute it with PHP)

ZF2 Skeleton Application
------------------------

Create a new Skeleton application with Composer:

```bash
$ php composer.phar create-project -sdev --repository-url="https://packages.zendframework.com" \
    zendframework/skeleton-application doctrine-odm-tutorial
```

Grab a coffee and wait for composer to finish installing your new ZF2 Application. Now you can start up your application
with the php built-in web server:

```bash
$ cd doctrine-odm-tutorial
$ php -S 0.0.0.0:8080 -t public/ public/index.php
```

For detailed instructions on installing the Zend Framework 2 Skeleton Application follow 
[this link](https://github.com/zendframework/ZendSkeletonApplication).

Install Doctrine Mongo ODM Module 
-----------------------------------------

Add the DoctrineODMModule to your requirements in `composer.json`:

```json
{
    "minimum-stability": "alpha",
    "require": {
        "doctrine/doctrine-mongo-odm-module": "dev-master"
    }
}
```
Now run `php composer.phar update` to fetch doctrine-odm-module.

Open `doctrine-odm-tutorial/configs/application.config.php` in your editor and add following keys to your `modules` 
(in this order)

```php
'DoctrineModule',
'DoctrineMongoODMModule',
```

Copy `vendor/doctrine/doctrine-mongo-odm-module/config/module.doctrine-mongo-odm.local.php.dist` into your application's
`config/autoload` directory, rename it to `module.doctrine-mongo-odm.local.php` and make the appropriate changes.
     
Create the directories `my/project/directory/data/DoctrineMongoODMModule/Proxy` and
`my/project/directory/data/DoctrineMongoODMModule/Hydrator` and make sure your application has write access to them.

Configure your Application module
---------------------------------

Open `module/Application/config/module.config.php` and add the namespace to the top of the file:

```php
<?php

namespace Application;
```

Add this to the configuration array:

```php
return [
    // ...
    
    // to register classes in the "/Document" folder of any module,
    // you can copy&paste this block to a module config without modifying it.
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Document']
            ],
            'odm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Document' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];
```

Create a managed document class
-----------------------

Create your first Doctrine ODM managed document class in `module/Application/src/Application/Document/Message.php`:

```php
<?php

namespace Application\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class Message
{
    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $text;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }
}
```

Test the newly created document
-------------------------------

To test your Doctrine ODM configuration, replace the indexAction in 
`module/Application/src/Application/Controller/IndexController.php`:

```php
<?php
//...

use Application\Document\Message;

    //...
    public function indexAction()
    {
        $message = new Message();
        $message->setText("Hello Doctrine!");

        $dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
        $dm->persist($message);
        $dm->flush();

        var_dump($message);

        return new ViewModel();
    }
    //...
```

The dumped variable should contain a new generated id:

```php
object(Application\Document\Message)[252]
      protected 'id' => string '546a6bf935568055040041a9' (length=24)
      protected 'text' => string 'Hello Doctrine!' (length=15)
```