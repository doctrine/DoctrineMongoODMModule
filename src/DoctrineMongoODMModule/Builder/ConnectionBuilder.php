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
namespace DoctrineMongoODMModule\Builder;

use DoctrineModule\Builder\BuilderInterface;
use DoctrineModule\Exception;
use DoctrineMongoODMModule\Options\ConnectionOptions;
use Doctrine\MongoDB\Connection;

/**
 * Builder creates a mongo connection
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConnectionBuilder implements BuilderInterface
{
    /**
     * @return \Doctrine\MongoDB\Connection
     */
    public function build($options)
    {
        if (is_array($options) || $options instanceof \Traversable) {
            $options = new ConnectionOptions($options);
        } elseif (! $options instanceof ConnectionOptions) {
            throw new Exception\InvalidArgumentException();
        }

        $connectionString = 'mongodb://';
        if ($options->getUser() && $options->getPassword()) {
            $connectionString .= $options->getUser() . ':' . $options->getPassword() . '@';
        }
        $connectionString .= $options->getServer() . ':' . $options->getPort();
        if ($options->getDbName()) {
            $connectionString .= '/' . $options->getDbName();
        }
        return new Connection(
            $connectionString,
            $options->getOptions()
        );
    }
}
