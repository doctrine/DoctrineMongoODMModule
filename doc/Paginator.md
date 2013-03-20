Pagination Adapter
==================

#### Example:

```php

use Zend\Paginator\Paginator;
use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;

// Create a mongo cursor
$cursor = $documentManager->getRepository('Users')->findAll();

// Create the pagination adapter
$paginationAdapter = DoctrinePaginator($cursor);

// Create the paginator itself
$paginator = new Paginator($adapter);
$paginator->setCurrentPageNumber(1)
          ->setItemCountPerPage(5);

// Pass it to the view, and use it like a "standard" Zend paginator
```
