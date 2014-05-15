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
class ImageItemCarouselThumbnail extends ImageCopy
{
    protected $maxWidth = 120;
    protected $maxHeight = 80;
    protected $sufix = "carousel-thumb";
    protected $crop = true;
}