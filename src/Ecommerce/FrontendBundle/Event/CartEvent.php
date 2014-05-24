<?php
namespace Ecommerce\FrontendBundle\Event;

use Ecommerce\FrontendBundle\Model\Cart;
use Symfony\Component\EventDispatcher\Event;

class CartEvent extends Event implements \Serializable
{
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getCart()
    {
        return $this->cart;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array($this->cart));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->cart = unserialize($serialized);
    }

}