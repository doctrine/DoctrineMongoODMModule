Pagination Adapter
==================

#### Example:

```php
// note: the cursor is not executed until you receive items from the pagination adapter
$cursor            = $documentManager->getRepository('Users')->findAll();
$paginationAdapter = DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator($cursor);

// Get first 5 users. Only the first five users are fetched from MongoDB.
$users = $paginationAdapter->getItems(0, 5);

// If you call it the second time, a new query is executed on MongoDB.
$users2 = $paginationAdapter->getItems(5, 5);
```