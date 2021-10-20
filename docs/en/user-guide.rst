User Guide
==========

This guide helps you to create a Laminas application with Doctrine Mongo
ODM integration. If you’re new to Laminas, please read the `Laminas
documentation <https://docs.laminas.dev/>`__ before you continue.

Install Composer
----------------

install composer via ``curl -s http://getcomposer.org/installer | php``
(on windows, download http://getcomposer.org/installer and execute it
with PHP)

Laminas Skeleton Application
----------------------------

Create a new Skeleton application with Composer:

.. code:: bash

   $ composer create-project laminas/laminas-mvc-skeleton doctrine-odm-tutorial

Grab a coffee and wait for composer to finish installing your new
Laminas Application. Now you can start up your application with the php
built-in web server:

.. code:: bash

   $ cd doctrine-odm-tutorial
   $ php -S 0.0.0.0:8080 -t public/ public/index.php

For detailed instructions on installing the Laminas MVC Skeleton
Application follow `this
link <https://github.com/laminas/laminas-mvc-skeleton>`__.

Install Doctrine Mongo ODM Module
---------------------------------

Install DoctrineODMModule :

.. code:: bash

   $ composer require doctrine/doctrine-mongo-odm-module

Open ``doctrine-odm-tutorial/configs/application.config.php`` in your
editor and add following keys to your ``modules`` (in this order)

.. code:: php

   'DoctrineModule',
   'DoctrineMongoODMModule',

Copy
``vendor/doctrine/doctrine-mongo-odm-module/config/module.doctrine-mongo-odm.local.php.dist``
into your application’s ``config/autoload`` directory, rename it to
``module.doctrine-mongo-odm.local.php`` and make the appropriate
changes.

Create the directories
``my/project/directory/data/DoctrineMongoODMModule/Proxy`` and
``my/project/directory/data/DoctrineMongoODMModule/Hydrator`` and make
sure your application has write access to them.

Configure your Application module
---------------------------------

Open ``module/Application/config/module.config.php`` and add the
namespace to the top of the file:

.. code:: php

   <?php

   namespace Application;

Add this to the configuration array:

.. code:: php

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

Create a managed document class
-------------------------------

Create your first Doctrine ODM managed document class in
``module/Application/src/Application/Document/Message.php``:

.. code:: php

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

Test the newly created document
-------------------------------

To test your Doctrine ODM configuration, replace the indexAction in
``module/Application/src/Application/Controller/IndexController.php``:

.. code:: php

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

The dumped variable should contain a new generated id:

.. code:: php

   object(Application\Document\Message)[252]
         protected 'id' => string '546a6bf935568055040041a9' (length=24)
         protected 'text' => string 'Hello Doctrine!' (length=15)
