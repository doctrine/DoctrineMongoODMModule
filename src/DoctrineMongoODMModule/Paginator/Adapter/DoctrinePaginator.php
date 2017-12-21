<?php

namespace DoctrineMongoODMModule\Paginator\Adapter;

use Zend\Paginator\Adapter\AdapterInterface;
use Doctrine\MongoDB\EagerCursor;
use Doctrine\ODM\MongoDB\Cursor;

/**
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Roman Konz <roman@konz.me>
 */
class DoctrinePaginator implements AdapterInterface
{
    /**
     * @var Cursor
     */
    protected $cursor;

    /**
     * Constructor
     *
     * @param Cursor $cursor
     */
    public function __construct(Cursor $cursor)
    {
        $this->cursor = $cursor;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        // Avoid using EagerCursor::count as this stores a collection without limits to memory
        if ($this->cursor->getBaseCursor() instanceof EagerCursor) {
            return $this->cursor->getBaseCursor()->getCursor()->count();
        }

        return $this->cursor->count();
    }

    /**
     * {@inheritDoc}
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $cursor = clone $this->cursor;

        $cursor->recreate();
        $cursor->skip($offset);
        $cursor->limit($itemCountPerPage);
        // Return array version so that counting is correct
        return $cursor->toArray(false);
    }
}
