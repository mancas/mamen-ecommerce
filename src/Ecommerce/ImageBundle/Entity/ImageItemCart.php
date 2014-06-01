<?php
namespace Ecommerce\ImageBundle\Entity;
use Doctrine\Tests\DBAL\Types\IntegerTest;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ImageItemCart extends ImageCopy
{
    protected $maxWidth = 120;
    protected $maxHeight = 60;
    protected $sufix = "cart";
    protected $crop = false;
}