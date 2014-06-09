<?php

namespace Ecommerce\CartBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\CartBundle\Event\CartEvent;
use Ecommerce\CartBundle\Event\CartEvents;
use Ecommerce\CartBundle\Storage\CartStorageManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Routing\Router;

class CartEventSubscriber implements EventSubscriberInterface
{
    protected $cartStorageManager;
    protected $manager;

    public static function getSubscribedEvents()
    {
        return array(
            CartEvents::NEW_CART => 'initializeCart'
        );
    }

    public function __construct(CartStorageManager $cartStorageManager, ObjectManager $manager)
    {
        $this->cartStorageManager = $cartStorageManager;
        $this->manager = $manager;
    }

    public function initializeCart(CartEvent $event)
    {
        if (!$this->cartStorageManager->getCurrentCart())
            $this->cartStorageManager->setCurrentCart($event->getCart());
        $this->manager->persist($event->getCart());
        $this->manager->flush();
    }
}