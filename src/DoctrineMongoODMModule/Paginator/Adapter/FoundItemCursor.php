<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace DoctrineMongoODMModule\Paginator\Adapter;

use Doctrine\MongoDB\Cursor;

/**
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Chris Levy <chrisianlevy@yahoo.co.uk>
 * 
 * Decorator for Doctrine\MongoDB\Cursor, this will return "found item" count by default
 */
class FoundItemCursor extends Cursor
{
    /**
     * @var Doctrine\MongoDB\Cursor
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
     * Return the Cursor being wrapped
     */
    public function getCursor()
    {
        return $this->cursor;
    }
    
    /**
     * Returns the number of "found" items in a cursor
     *
     * @return int
     */
    public function count()
    {
        return $this->cursor->count(true);
    }
    
    /**
     * {@inheritdoc }
     */
    public function getConnection()
    {
        return $this->cursor->getConnection();
    }

    /**
     * {@inheritdoc }
     */
    public function getCollection()
    {
        return $this->cursor->getCollection();
    }

    /**
     * {@inheritdoc }
     */
    public function getQuery()
    {
        return $this->cursor->getQuery();
    }

    /**
     * {@inheritdoc }
     */
    public function getFields()
    {
        return $this->cursor->getFields();
    }

    /**
     * {@inheritdoc }
     */
    public function recreate()
    {
        $this->cursor->recreate();
    }

    /**
     * {@inheritdoc }
     */
    public function getMongoCursor()
    {
        return $this->cursor->getMongoCursor();
    }

    /**
     * {@inheritdoc }
     */
    public function current()
    {
        return $this->cursor->current();
    }

    /**
     * {@inheritdoc }
     */
    public function key()
    {
        return $this->cursor->key();
    }

    /**
     * {@inheritdoc }
     */
    public function dead()
    {
        return $this->cursor->dead();
    }

    /**
     * {@inheritdoc }
     */
    public function explain()
    {
        return $this->cursor->explain();
    }

    /**
     * {@inheritdoc }
     */
    public function fields(array $f)
    {
        $this->cursor->fields($f);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function getNext()
    {
        return $this->cursor->next();
    }

    /**
     * {@inheritdoc }
     */
    public function hasNext()
    {
        return $this->cursor->hasNext();
    }

    /**
     * {@inheritdoc }
     */
    public function hint(array $keyPattern)
    {
        $this->cursor->hint($keyPattern);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function immortal($liveForever = true)
    {
        $this->cursor->immortal($liveForever);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function info()
    {
        return $this->cursor->info();
    }

    /**
     * {@inheritdoc }
     */
    public function rewind()
    {
        return $this->cursor->rewind();
    }

    /**
     * {@inheritdoc }
     */
    public function next()
    {
        return $this->cursor->next();
    }

    /**
     * {@inheritdoc }
     */
    public function reset()
    {
        return $this->cursor->reset();
    }   

    /**
     * {@inheritdoc }
     */
    public function addOption($key, $value)
    {
        $this->cursor->addOption($key, $value);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function batchSize($num)
    {
        $this->cursor->batchSize($num);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function limit($num)
    {
        $this->cursor->limit($num);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function skip($num)
    {
        $this->cursor->skip($num);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function slaveOkay($ok = true)
    {
        $this->cursor->slaveOkay($ok);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function setMongoCursorSlaveOkay($ok)
    {
        $this->cursor->setMongoCursorSlaveOkay($ok);
    }

    /**
     * {@inheritdoc }
     */
    public function snapshot()
    {
        $this->cursor->snapshot();
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function sort($fields)
    {
        $this->cursor->sort($fields);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function tailable($tail = true)
    {
        $this->cursor->tailable($tail);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function timeout($ms)
    {
        $this->cursor->timeout($ms);
        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function valid()
    {
        return $this->cursor->valid();
    }

    /**
     * {@inheritdoc }
     */
    public function toArray($useKeys = true)
    {
        return $this->cursor->toArray($useKeys);
    }

    /**
     * {@inheritdoc }
     */
    public function getSingleResult()
    {
        return $this->cursor->getSingleResult();
    }

    /**
     * {@inheritdoc }
     */
    protected function retry(\Closure $retry, $recreate = false)
    {
        return $this->cursor->retry($retry, $recreate);
    }
}
