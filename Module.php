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
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace DoctrineMongoODMModule;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain;
use Zend\ModuleManager\ModuleManager;

/**
 * DoctrineModule provider for Mongo DB.
 *
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    www.doctrine-project.org
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfiguration()
    {
        return array(
            'aliases' => array(
                'doctrine_odm_metadata_cache'  => 'Doctrine\Common\Cache\ArrayCache',
            ),
            'factories' => array(
                'doctrine_odm_cli'                 => 'DoctrineODMModule\Service\CliFactory',
                'Doctrine\Common\Cache\ArrayCache' => function() { return new ArrayCache; },
                'Doctrine\MongoDB\Connection'       => 'DoctrineMongoODMModule\Service\ConnectionFactory',               
                'Doctrine\ODM\MongoDB\Configuration'       => 'DoctrineMongoODMModule\Service\ConfigurationFactory',
                'Doctrine\ODM\MongoDB\DocumentManager'       => 'DoctrineMongoODMModule\Service\DocumentManagerFactory',
                'Doctrine\Common\Annotations\CachedReader'       => 'DoctrineMongoODMModule\Service\CachedReaderFactory',
                'Doctrine\Common\EventManager'       => 'DoctrineMongoODMModule\Service\EventManagerFactory',          
            )
        );
    }    
}