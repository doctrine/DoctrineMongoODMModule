Usage of DoctrineMongoODMModule
===============================

The DoctrineMongoODMModule integrates Doctrine MongoDB ODM with Laminas
quickly and easily. The following features are intended to work out of
the box:

-  MongoDB support
-  Multiple document managers
-  Multiple connections
-  Support for using existing ``Mongo`` connections
-  Doctrine CLI support

Installation
------------

Run the following to install this library:

.. code:: bash
   $ composer require doctrine/doctrine-mongo-odm-module

Copy
``vendor/doctrine/doctrine-mongo-odm-module/config/module.doctrine-mongo-odm.local.php.dist``
into your application’s ``config/autoload`` directory, rename it to
``module.doctrine-mongo-odm.local.php``, and make the appropriate
changes. With this config file you can configure your mongo connection,
add extra annotations to register, add subscribers to the event manager,
add filters to the filter collection, and drivers to the driver chain.

Then add ``DoctrineModule`` and ``DoctrineMongoODMModule`` to your
``config/application.config.php`` and create directories
``data/DoctrineMongoODMModule/Proxy`` and
``data/DoctrineMongoODMModule/Hydrator`` and make sure your application
has write access to them.

Installation without composer is not officially supported and requires
you to manually install all dependencies that are listed in
``composer.json``

Next Steps
----------

.. toctree::
    :caption: Table of Contents

    usage
    user-guide
    development
