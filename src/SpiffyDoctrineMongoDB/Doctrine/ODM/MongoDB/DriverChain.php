<?php
namespace SpiffyDoctrineMongoODM\Doctrine\ODM\MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain as MongoDriverChain,
    SpiffyDoctrine\Doctrine\Common\DriverChain as CommonDriverChain;

class DriverChain extends CommonDriverChain
{
	protected $annotationDriverClass = 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver';
    protected $driverChainClass      = 'Doctrine\ODM\MongoDB\Mapping\Driver\DriverChain';
}