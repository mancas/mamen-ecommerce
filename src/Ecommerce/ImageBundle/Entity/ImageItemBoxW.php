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
class ImageItemBoxW extends ImageCopy
{
    protected $maxWidth = 740;
    protected $maxHeight = 225;
    protected $sufix = "boxw";
    protected $crop = true;
}