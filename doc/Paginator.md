Pagination Adapter
==================

#### Example:

```php

use Laminas\Paginator\Paginator;
use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;

// Create a mongo cursor
$cursor = $documentManager->createQueryBuilder('User')
                          ->getQuery()
                          ->execute();

// Create the pagination adapter
$adapter = new DoctrinePaginator($cursor);

// Create the paginator itself
$paginator = new Paginator($adapter);
$paginator->setCurrentPageNumber(1)
          ->setItemCountPerPage(5);

// Pass it to the view, and use it like a "standard" Zend paginator
```
