<?php

namespace Ecommerce\FrontendBundle\Controller;

use Ecommerce\CartBundle\Event\CartEvent;
use Ecommerce\CartBundle\Event\CartEvents;
use Ecommerce\CartBundle\Model\Cart;
use Ecommerce\CartBundle\Storage\CartStorageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontendController extends CustomController
{
    const ITEMS_LIMIT_DQL = 6;
    const CATEGORIES_IN_INDEX = 3;

    public function indexAction()
    {
        $em = $this->getEntityManager();

        $recentItems = $em->getRepository('ItemBundle:Item')->findRecentItemsDQL(self::ITEMS_LIMIT_DQL);
        $seoCategories = $em->getRepository('CategoryBundle:Category')->findSEOCategories(self::CATEGORIES_IN_INDEX);
        $indexCategories = array();

        foreach ($seoCategories as $seoCategory) {
            $indexCategories[$seoCategory->getName()] = $em->getRepository('ItemBundle:Item')->findCategorySEOItemsDQL($seoCategory, self::ITEMS_LIMIT_DQL);
        }

        $cartStorageManager = $this->getCartStorageManager();
        if (!$cartStorageManager->getCurrentCart())
        {
            ld('not cart');
            $cart = new Cart();
            $now = new \DateTime();
            $now->modify('+ 1day');
            $cart->setExpiredAt($now);
            $cartEvent = new CartEvent($cart);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(CartEvents::NEW_CART, $cartEvent);
        }

        return $this->render('FrontendBundle:Pages:home.html.twig', array('recentItems' => $recentItems, 'seoCategories' => $indexCategories));
    }

    /**
     * @Template("FrontendBundle:Commons:category-navbar.html.twig")
     *
     * @return array
     */
    public function categoryNavAction()
    {
        $em = $this->getEntityManager();
        $categories = $em->getRepository('CategoryBundle:Category')->findCategoriesDQL();

        return array('categories' => $categories);
    }
}
