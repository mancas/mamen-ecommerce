<?php

namespace Ecommerce\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecommerce\UserBundle\Entity\AddressRepository")
 * @DoctrineAssert\UniqueEntity("id")
 * @UniqueEntity("id")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected  $id;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="Ecommerce\UserBundle\Entity\User", inversedBy="addresses")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" = 0})
     */
    protected $main = false;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @ORM\Column(name="deleted", type="date", nullable=true)
     * @Assert\Date()
     */
    protected $deleted;

    /**
     * @var date $created
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime", nullable=true)
     * @Assert\Date()
     */
    protected $created;

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
     * @param \Ecommerce\UserBundle\Entity\date $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \Ecommerce\UserBundle\Entity\date
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $main
     */
    public function setMain($main)
    {
        $this->main = $main;
    }

    /**
     * @return mixed
     */
    public function getMain()
    {
        return $this->main;
    }
}