<?php

namespace DoctrineMongoODMModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\EventManager;
use Zend\EventManager\EventManager as ZendEventManager;

class EventManagerFactory implements FactoryInterface
{
    /**
     * @var \Zend\EventManager\EventManager
     */
    protected $events;
    
    protected $subscribers;
    
    public function createService(ServiceLocatorInterface $sl)
    {
        $eventManager = new EventManager();
        $subscribers = $this->getSubscribers($sl);
        foreach($subscribers as $subscriber){
            $eventManager->addEventSubscriber($subscriber);                        
        }
        return $eventManager;
    }
    
    protected function events()
    {
        if (null === $this->events) {
            $events = new ZendEventManager;
            $events->setIdentifiers(array(
                'DoctrineMongoODMModule'
            ));

            $this->events = $events;
        }
        return $this->events;
    }  
    
    protected function getSubscribers(ServiceLocatorInterface $sl)
    {
        if (null === $this->subscribers) {
            $events = $this->events();            
            $this->subscribers = array();
            
            // TODO: Temporary workaround for EventManagerFactory. Remove when file is patched.
            $events->setSharedManager($sl->get('ModuleManager')->events()->getSharedManager());

            $collection = $events->trigger('loadSubscribers', $sl);
            foreach($collection as $response) {
                $this->subscribers = array_merge($this->subscribers, $response);
            }          
        }
        return $this->subscribers;
    }    
}