<?php

namespace Ecommerce\FrontendBundle\Controller;

use Ecommerce\FrontendBundle\Event\CartEvent;
use Ecommerce\FrontendBundle\Event\CartEvents;
use Ecommerce\FrontendBundle\Model\Cart;
use Ecommerce\FrontendBundle\Model\CartItem;
use Ecommerce\FrontendBundle\Storage\CartStorageManager;
use Ecommerce\ItemBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CartController extends CustomController
{
    /**
     * @ParamConverter("item", class="ItemBundle:Item")
     */
    public function addItemAction(Item $item, Request $request)
    {
        $jsonResponse = json_encode(array('ok' => false));
        if ($request->isXmlHttpRequest()) {
            $cartStorageManager = $this->getCartStorageManager();
            $currentCart = $cartStorageManager->getCurrentCart();
            $cartItem = new CartItem($item->getId(), 1, $item->getPrice());
            $currentCart->addCartItem($cartItem);
            $jsonResponse = json_encode(array('ok' => true));
        }

        return $this->getHttpJsonResponse($jsonResponse);
    }

    public function emptyCartAction(Request $request)
    {
        $jsonResponse = json_encode(array('ok' => false));
        if ($request->isXmlHttpRequest()) {
            $cartStorageManager = $this->getCartStorageManager();
            $currentCart = $cartStorageManager->getCurrentCart();
            $currentCart->resetCart();
            $jsonResponse = json_encode(array('ok' => true));
        }

        return $this->getHttpJsonResponse($jsonResponse);
    }

    public function cartTemplateAction()
    {
        $cartStorageManager = $this->getCartStorageManager();
        $cart = $cartStorageManager->getCurrentCart();

        return $this->render("FrontendBundle:Commons:cart.html.twig", array('cart' => $cart));
    }

    /**
     * @Template("FrontendBundle:Commons:cart.html.twig")
     *
     * @return array
     */
    public function cartAction()
    {
        $cartStorageManager = $this->getCartStorageManager();
        $cart = $cartStorageManager->getCurrentCart();

        return array('cart' => $cart);
    }
}
