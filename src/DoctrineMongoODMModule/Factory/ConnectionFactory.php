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
namespace DoctrineMongoODMModule\Factory;

use DoctrineModule\Factory\AbstractFactoryInterface;
use Doctrine\MongoDB\Connection;

/**
 * Factory creates a mongo connection
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConnectionFactory implements AbstractFactoryInterface
{

    const OPTIONS_CLASS = '\DoctrineMongoODMModule\Options\Connection';

    /**
     * @return \Doctrine\MongoDB\Connection
     */
    public function create($options)
    {
        $optionsClass = self::OPTIONS_CLASS;

        if (is_array($options) || $options instanceof \Traversable) {
            $options = new $optionsClass($options);
        } elseif (! $options instanceof $optionsClass) {
            throw new \InvalidArgumentException();
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
