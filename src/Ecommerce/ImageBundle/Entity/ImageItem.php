<?php

namespace Ecommerce\ImageBundle\Entity;

use Ecommerce\ImageBundle\Entity\Image;
use Ecommerce\ImageBundle\Util\FileHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class ImageItem extends Image
{
    CONST MAX_WIDTH = 1024;
    CONST MAX_HEIGHT = 768;
    protected $subdirectory = "images/products";
    protected $maxWidth = self::MAX_WIDTH;
    protected $maxHeight = self::MAX_HEIGHT;

    /**
     * @ORM\ManyToOne(targetEntity="Ecommerce\ItemBundle\Entity\Item", inversedBy="images")
     */
    protected $item;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" = 0})
     */
    protected $main = false;

    public function setItem(\Ecommerce\ItemBundle\Entity\Item $item)
    {
        $this->item = $item;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function createImageItemBox()
    {
        $thumb = $this->getImageItemBox();
        if (!$thumb) {
            $thumb = new ImageItemBox();
        }

        return $thumb;
    }

    public function createImageItemBoxW()
    {
        $thumb = $this->getImageItemBoxW();
        if (!$thumb) {
            $thumb = new ImageItemBoxW();
        }

        return $thumb;
    }

    public function createCopies()
    {
        list($oldRoute, $copies) = parent::createCopies();
        if ($box = $this->createImageItemBox()) {
            $copies[] = $box;
        }

        if ($boxw = $this->createImageItemBoxW()) {
            $copies[] = $boxw;
        }

        return array($oldRoute, $copies);
    }

    public function getMain()
    {
        return $this->main;
    }

    public function setMain($main)
    {
        $this->main = $main;
    }

}
