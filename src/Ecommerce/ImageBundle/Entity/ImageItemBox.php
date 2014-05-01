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
class ImageItemBox extends ImageCopy
{
    protected $maxWidth = 358;
    protected $maxHeight = 225;
    protected $sufix = "box";
    protected $crop = true;
}