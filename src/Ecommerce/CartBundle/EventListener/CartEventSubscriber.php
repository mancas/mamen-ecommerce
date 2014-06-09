<?php

namespace Ecommerce\CartBundle\EventListener;

use Ecommerce\CartBundle\Event\CartEvent;
use Ecommerce\CartBundle\Event\CartEvents;
use Ecommerce\CartBundle\Storage\CartStorageManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Router;

class CartEventSubscriber implements EventSubscriberInterface
{
    protected $cartStorageManager;

    public static function getSubscribedEvents()
    {
        return array(
            CartEvents::NEW_CART => 'initializeCart',
            CartEvents::CLEAR_CART => 'clearCart'
        );
    }

    public function __construct(CartStorageManager $cartStorageManager)
    {
        $this->cartStorageManager = $cartStorageManager;
    }

    public function initializeCart(CartEvent $event)
    {
        if (!$this->cartStorageManager->getCurrentCart())
            $this->cartStorageManager->setCurrentCart($event->getCart());
    }

    public function clearCart(CartEvent $event)
    {
        $cart = $event->getCart();
        $cart->resetCart();
    }
}