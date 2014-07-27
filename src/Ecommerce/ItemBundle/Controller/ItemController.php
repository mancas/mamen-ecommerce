<?php

namespace Ecommerce\ItemBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\ItemBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ItemController extends CustomController
{
    const RELATED_ITEMS_LIMIT = 8;
    /**
     * @param Item $item
     *
     * @Template("ItemBundle:Commons:item-box.html.twig")
     *
     * @return array
     */
    public function itemBoxAction(Item $item)
    {
        return array('item' => $item);
    }

    /**
     * @ParamConverter("item", class="ItemBundle:Item")
     */
    public function detailsAction(Item $item)
    {
        $em = $this->getEntityManager();
        $relatedItems = $em->getRepository('ItemBundle:Item')->findRelatedItems($item, self::RELATED_ITEMS_LIMIT);

        if ($item->getDeleted()) {
            $this->setTranslatedFlashMessage('Este producto ha sido eliminado');
            return $this->redirect($this->generateUrl('frontend_homepage'));
        }

        return $this->render('ItemBundle:Item:details.html.twig', array('item' => $item, 'relatedItems' => $relatedItems));
    }
}
