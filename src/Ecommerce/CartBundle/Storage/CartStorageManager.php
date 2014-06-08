<?php
namespace Ecommerce\CartBundle\Storage;

use Ecommerce\CartBundle\Model\Cart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartStorageManager
{
    const KEY = '_cart_session_clop';

    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getCurrentCart()
    {
        return $this->session->get(self::KEY);
    }

    public function setCurrentCart(Cart $cart)
    {
        $this->session->set(self::KEY, $cart);
    }

    public function removeCurrentCart()
    {
        $this->session->remove(self::KEY);
    }
}