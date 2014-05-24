<?php
namespace Ecommerce\FrontendBundle\Storage;

use Ecommerce\FrontendBundle\Model\Cart;
use Symfony\Component\HttpFoundation\Session\Session;

class CartStorageManager
{
    const KEY = '_cart_session_ecommerce';

    protected $session;

    public function __construct(Session $session)
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