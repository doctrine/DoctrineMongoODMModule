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

/**
 * Decorator for Doctrine\MongoDB\Cursor, this will return "found item" count by default
 */

namespace DoctrineMongoODMModule\Paginator\Adapter;

use Doctrine\MongoDB\Cursor;

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
     * Returns the number of "found" items in a cursor
     *
     * @return int
     */
    public function count()
    {
        return $this->cursor->count(true);
    }
    
    public function getConnection()
    {
        return $this->cursor->getConnection();
    }

    public function getCollection()
    {
        return $this->cursor->getCollection();
    }

    public function getQuery()
    {
        return $this->cursor->getQuery();
    }

    public function getFields()
    {
        return $this->cursor->getFields();
    }

    public function recreate()
    {
        $this->cursor->recreate();
    }

    /**
     * Returns the MongoCursor instance being wrapped.
     *
     * @return MongoCursor $mongoCursor The MongoCursor instance being wrapped.
     */
    public function getMongoCursor()
    {
        return $this->cursor->getMongoCursor();
    }

    public function current()
    {
        return $this->cursor->current();
    }

    public function key()
    {
        return $this->cursor->key();
    }

    public function dead()
    {
        return $this->cursor->dead();
    }

    public function explain()
    {
        return $this->cursor->explain();
    }

    public function fields(array $f)
    {
        $this->cursor->fields($f);
        return $this;
    }

    public function getNext()
    {
        return $this->cursor->next();
    }

    public function hasNext()
    {
        return $this->cursor->hasNext();
    }

    public function hint(array $keyPattern)
    {
        $this->cursor->hint($keyPattern);
        return $this;
    }

    public function immortal($liveForever = true)
    {
        $this->cursor->immortal($liveForever);
        return $this;
    }

    public function info()
    {
        return $this->cursor->info();
    }

    public function rewind()
    {
        return $this->cursor->rewind();
    }

    public function next()
    {
        return $this->cursor->next();
    }

    public function reset()
    {
        return $this->cursor->reset();
    }   

    public function addOption($key, $value)
    {
        $this->cursor->addOption($key, $value);
        return $this;
    }

    public function batchSize($num)
    {
        $this->cursor->batchSize($num);
        return $this;
    }

    public function limit($num)
    {
        $this->cursor->limit($num);
        return $this;
    }

    public function skip($num)
    {
        $this->cursor->skip($num);
        return $this;
    }

    public function slaveOkay($ok = true)
    {
        $this->cursor->slaveOkay($ok);
        return $this;
    }

    public function setMongoCursorSlaveOkay($ok)
    {
        $this->cursor->setMongoCursorSlaveOkay($ok);
    }

    public function snapshot()
    {
        $this->cursor->snapshot();
        return $this;
    }

    public function sort($fields)
    {
        $this->cursor->sort($fields);
        return $this;
    }

    public function tailable($tail = true)
    {
        $this->cursor->tailable($tail);
        return $this;
    }

    public function timeout($ms)
    {
        $this->cursor->timeout($ms);
        return $this;
    }

    public function valid()
    {
        return $this->cursor->valid();
    }

    public function toArray($useKeys = true)
    {
        return $this->cursor->toArray($useKeys);
    }

    /**
     * Get the first single result from the cursor.
     *
     * @return array $document  The single document.
     */
    public function getSingleResult()
    {
        return $this->cursor->getSingleResult();
    }

    protected function retry(\Closure $retry, $recreate = false)
    {
        return $this->cursor->retry($retry, $recreate);
    }
}