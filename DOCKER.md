Development and testing using Docker
====================================

Because this library uses mongodb a docker-compose
file is included to bring up a suitable environment for development.

This environment uses PHP 7.1.


Build Docker
------------

Clone the project locally and cd into the project.
Run `docker-compose up -d` to build the environment.
Run `docker/connect` to connect to the PHP container.
`cd` to the `/var/www` directory.


Composer
--------

Run this to install mongo support on top of mongodb
```
composer config "platform.ext-mongo" "1.6.16" && composer require alcaeus/mongo-php-adapter
```

Configuration
-------------

Edit the file `config/module.config.php` and replace `localhost` with `mongodb`.  This file needs localhost for Travis testing but you'll be using the mongodb container locally.


Testing
-------

To ensure everything is working run the unit tests
```
vendor/bin/phpunit
```
