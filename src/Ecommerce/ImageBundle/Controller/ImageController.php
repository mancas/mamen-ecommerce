<?php

namespace Ecommerce\ImageBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\FrontendBundle\Util\FunctionsHelper;
use Ecommerce\ImageBundle\Util\FileHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\ImageBundle\Entity\ImageItem;
use Ecommerce\ImageBundle\Entity\ImageCopy;
use Ecommerce\ImageBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends CustomController
{
    /**
     * @ParamConverter("imageItem", class="ImageBundle:ImageItem")
     */
    public function deleteImageAction(ImageItem $imageItem, Request $request)
    {
        $jsonResponse = json_encode(array('ok' => false));
        if ($request->isXmlHttpRequest()) {
            $em = $this->getEntityManager();

            if (!$imageItem) {
                return $this->noPermission();
            }
            foreach ($imageItem->getImageCopies() as $copy)
            {
                $copy->setDateRemove(new \DateTime('now'));
                $em->flush();
                FileHelper::removeFileFromDirectory($copy->getImageName(), $copy->getSubdirectory());
            }
            $imageItem->setDeletedDate(new \DateTime('now'));
            if (FunctionsHelper::isClass($imageItem, "imageItem") && $imageItem->getMain()) {
                $imageItem->setMain(false);
            }
            $em->flush();
            FileHelper::removeFileFromDirectory($imageItem->getImage(), $imageItem->getSubdirectory());
            $jsonResponse = json_encode(array('ok' => true));
        }

        return $this->getHttpJsonResponse($jsonResponse);
    }
}
