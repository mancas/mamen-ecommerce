<?php
namespace Ecommerce\ItemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\OrderBundle\Entity\Order;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Delivery
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="type", type="string", length=100, nullable=true)
     */
    protected $type;

    /**
     * @ORM\Column(name="cost", type="float")
     */
    protected $cost;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="date")
     */
    protected $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="date", nullable=true)
     */
    protected $updated;

    /**
     * @ORM\OneToMany(targetEntity="Ecommerce\OrderBundle\Entity\Order", mappedBy="delivery", cascade={"persist"})
     */
    protected $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
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
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    public function addOrder(Order $order)
    {
        if (!$this->orders->contains($order))
            $this->orders->add($order);
    }

    public function removeOrder(Order $order)
    {
        if ($this->orders->contains($order))
            $this->orders->removeElement($order);
    }
}