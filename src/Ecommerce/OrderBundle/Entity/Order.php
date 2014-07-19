<?php

namespace Ecommerce\OrderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\ItemBundle\Entity\Item;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * @ORM\Table(name="`Order`")
 * @ORM\Entity(repositoryClass="Ecommerce\OrderBundle\Entity\OrderRepository")
 * @DoctrineAssert\UniqueEntity("id")
 * @UniqueEntity("id")
 */
class Order
{
    const STATUS_READY = "Listo para envío";
    const STATUS_OUT_OF_STOCK = "Posible rotura de stock";
    const STATUS_SEND = "Enviado";
    const STATUS_READY_TO_TAKE = "Listo para recoger";
    const STATUS_IN_PROCESS = "En proceso";

    const DELIVERY_HOME = 'Delivery_home';
    const TAKE_IN_PLACE = 'Take_in_place';

    const DELIVERY_COST = 2.99;

    const PAYPAL_DESC = 'Pedido realizado en Clop';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Ecommerce\UserBundle\Entity\User", inversedBy="orders", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $customer;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    protected $date;

    /**
     * @ORM\OneToMany(targetEntity="Ecommerce\OrderBundle\Entity\OrderItem", mappedBy="order", cascade={"persist"})
     */
    protected $items;

    /**
     * @ORM\Column(name="status", type="string", length=100, nullable=true)
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Ecommerce\LocationBundle\Entity\Address")
     */
    protected $address;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" = 0})
     */
    protected $isPresent = false;

    /**
     * @ORM\OneToOne(targetEntity="Ecommerce\PaymentBundle\Entity\Payment", inversedBy="order")
     */
    protected $payment;

    /**
     *  @ORM\ManyToOne(targetEntity="Ecommerce\ItemBundle\Entity\Shipment")
     */
    protected $shipment;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    public function addItem(\Ecommerce\OrderBundle\Entity\OrderItem $item)
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }
    }

    public function removeItem(\Ecommerce\OrderBundle\Entity\OrderItem $item)
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusChoices()
    {
        return array(self::STATUS_READY => self::STATUS_READY,
            self::STATUS_OUT_OF_STOCK => self::STATUS_OUT_OF_STOCK,
            self::STATUS_SEND => self::STATUS_SEND,
            self::STATUS_READY_TO_TAKE => self::STATUS_READY_TO_TAKE,
            self::STATUS_IN_PROCESS => self::STATUS_IN_PROCESS);
    }

    /**
     * @Assert\Callback
     */
    protected function isStatusValid(ExecutionContextInterface $context)
    {
        if (!in_array($this->getStatus(), $this->getStatusChoices())) {
            $context->addViolationAt('status', 'This order status is not valid', array(), null);
        }
    }

    public function getTotalAmount()
    {
        $total = 0.0;
        foreach ($this->items as $orderRow) {
            $total += $orderRow->getPrice();
        }

        return $total + $this->shipment->getCost();
    }

    public function getTotalAmountWithoutTaxes()
    {
        $price = $this->getTotalAmount();
        $price = $price - ($price * Item::TAX_ES/100);

        return round($price, 2);
    }

    /**
     * @param mixed $isPresent
     */
    public function setIsPresent($isPresent)
    {
        $this->isPresent = $isPresent;
    }

    /**
     * @return mixed
     */
    public function getIsPresent()
    {
        return $this->isPresent;
    }

    /**
     * @param mixed $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $shipment
     */
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * @return mixed
     */
    public function getShipment()
    {
        return $this->shipment;
    }

}