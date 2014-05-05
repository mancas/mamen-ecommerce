<?php

namespace Ecommerce\ItemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecommerce\ItemBundle\Entity\ItemRepository")
 * @DoctrineAssert\UniqueEntity("id")
 * @UniqueEntity("id")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $description;

    /**
     * @ORM\Column(name="price", type="float")
     */
    protected $price;

    /**
     * @ORM\ManyToOne(targetEntity="Ecommerce\CategoryBundle\Entity\Category", inversedBy="items")
     */
    protected $category;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="Ecommerce\ImageBundle\Entity\ImageItem", mappedBy="item", cascade={"persist", "remove", "merge"})
     */
    protected $images;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\Column(name="deleted", type="date", nullable=true)
     * @Assert\Date()
     */
    protected $deleted;

    /**
     * @ORM\ManyToMany(targetEntity="Ecommerce\ItemBundle\Entity\Manufacturer", inversedBy="items")
     * @ORM\JoinTable(name="item_manufacturer")
     */
    protected $manufacturers;

    /**
     * @ORM\Column(type="integer")
     */
    protected $stock = 1;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->manufacturers = new ArrayCollection();
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
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
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
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
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
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        $images = array();
        foreach ($this->images as $image) {
            if ($image->getDeletedDate() == null)
                $images[] = $image;
        }

        return $images;
    }

    public function getImageMain()
    {
        foreach ($this->images as $image) {
            if ($image->getMain()) {
                return $image;
            }
        }

        return false;
    }

    /**
     * @param mixed $manufacturers
     */
    public function setManufacturers($manufacturers)
    {
        $this->manufacturers = $manufacturers;
    }

    /**
     * @return mixed
     */
    public function getManufacturers()
    {
        return $this->manufacturers;
    }

    public function addManufacturer(\Ecommerce\ItemBundle\Entity\Manufacturer $manufacturer)
    {
        if (!$this->manufacturers->contains($manufacturer)) {
            $this->manufacturers->add($manufacturer);
        }
    }

    public function removeManufacturer(\Ecommerce\ItemBundle\Entity\Manufacturer $manufacturer)
    {
        if ($this->manufacturers->contains($manufacturer)) {
            $this->manufacturers->remove($manufacturer);
        }
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }
}