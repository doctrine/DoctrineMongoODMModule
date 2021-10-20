Usage
=====

Command Line
------------

Access the Doctrine command line as following

.. code:: sh

   php public/index.php

or

.. code:: sh

   ./vendor/bin/doctrine-module

Service Locator
---------------

Access the document manager using this service manager alias:

.. code:: php

   $objectManager = $serviceManager->get('doctrine.documentmanager.odm_default');

Configuration
-------------

Connection section
~~~~~~~~~~~~~~~~~~

Either ``server`` or ``connectionString`` option has to be set.

+-----------------------+---------------+------------------------------+
| Name                  | Default       | Description                  |
+=======================+===============+==============================+
| server                | ‘localhost’   | IP of mongod instance        |
+-----------------------+---------------+------------------------------+
| port                  | 27017         | mongod port                  |
+-----------------------+---------------+------------------------------+
| connectionString      | null          | If the connection string is  |
|                       |               | specified, it will overwrite |
|                       |               | other connection options     |
|                       |               | (``serv                      |
|                       |               | er``,\ ``port``,\ ``user``,\ |
|                       |               |  ``password``,\ ``dbname``). |
|                       |               | Still, the connection will   |
|                       |               | respect the settings passed  |
|                       |               | in ``options`` array.        |
+-----------------------+---------------+------------------------------+
| user                  | null          | If set, the client will try  |
|                       |               | to authenticate with given   |
|                       |               | username and password        |
+-----------------------+---------------+------------------------------+
| password              | null          | If set, the client will try  |
|                       |               | to authenticate with given   |
|                       |               | username and password        |
+-----------------------+---------------+------------------------------+
| dbname                | null          | If dbname is not specified,  |
|                       |               | “admin” will be used for     |
|                       |               | authentication. Also,        |
|                       |               | specifiing dbname affecs the |
|                       |               | defaultDB configuration      |
|                       |               | option, if that’s not        |
|                       |               | specified explicitly.        |
+-----------------------+---------------+------------------------------+
| options               | array()       | Array with connection        |
|                       |               | options. More detailed       |
|                       |               | description in               |
|                       |               | http://www.php.net/manual/   |
|                       |               | en/mongoclient.construct.php |
+-----------------------+---------------+------------------------------+
