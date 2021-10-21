Development
===========

Unit tests rely on a mongo installation so all unit tests are ran
through docker. To run all unit tests execute:

.. code:: bash

   docker-compose run --rm php composer test

Running unit tests with code coverage requires you build the docker
composer with XDEBUG=1

.. code:: bash

   docker-compose build --build-arg XDEBUG=1

To change docker to a different php version

.. code:: bash

   docker-compose build --build-arg PHP_VERSION=7.3

then run the unit tests as

.. code:: bash

   docker-compose run --rm php composer test-coverage

Run phpcs as

.. code:: bash

   docker-compose run --rm php composer cs-check src test config
