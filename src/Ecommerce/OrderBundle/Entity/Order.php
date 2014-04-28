<?php

namespace Ecommerce\OrderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table()
 * @ORM\Entity()
 * @DoctrineAssert\UniqueEntity("id")
 * @UniqueEntity("id")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Ecommerce\UserBundle\Entity\User", cascade={"persist"})
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
     * @Assert\NotBlank()
     */
    protected $items;

    /**
     * @ORM\ManyToOne(targetEntity="Ecommerce\UserBundle\Entity\Address")
     * @Assert\NotBlank()
     */
    protected $address;

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

    public function addItem(Ecommerce\OrderBundle\Entity\OrderItem $item)
    {
        if (!$this->items->contains($item)) {
            $this->items->remove($item);
        }
    }

    public function removeItem(Ecommerce\OrderBundle\Entity\OrderItem $item)
    {
        if ($this->items->contains($item)) {
            $this->items->remove($item);
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
}