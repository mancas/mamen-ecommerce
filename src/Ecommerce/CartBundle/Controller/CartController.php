<?php

namespace Ecommerce\CartBundle\Controller;

use Ecommerce\CartBundle\Event\CartEvent;
use Ecommerce\CartBundle\Event\CartEvents;
use Ecommerce\CartBundle\Model\Cart;
use Ecommerce\CartBundle\Model\CartItem;
use Ecommerce\CartBundle\Storage\CartStorageManager;
use Ecommerce\FrontendBundle\Controller\CustomController;
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

    public function viewAction()
    {
        $cartStorageManager = $this->getCartStorageManager();
        $cart = $cartStorageManager->getCurrentCart();

        return $this->render("FrontendBundle:Pages:cart.html.twig", array('cart' => $cart));
    }

    public function deleteItemAction($id)
    {
        $cartStorageManager = $this->getCartStorageManager();
        $cart = $cartStorageManager->getCurrentCart();
        $cartItem = $cart->getCartItemById($id);
        $cart->removeCartItem($cartItem);

        return $this->redirect($this->generateUrl('cart_details'));
    }

    public function updateItemQuantityAction($id, Request $request)
    {
        $jsonResponse = json_encode(array('ok' => false));
        if ($request->isXmlHttpRequest()) {
            $quantity = $request->request->get('quantity');
            $cartStorageManager = $this->getCartStorageManager();
            $cart = $cartStorageManager->getCurrentCart();
            $cartItem = $cart->getCartItemById($id);
            if ($quantity == 0) {
                $cart->removeCartItem($cartItem);
            } else {
                $cartItem->setQuantity($quantity);
            }
            $jsonResponse = json_encode(array('ok' => true, 'path' => $this->generateUrl('cart_details')));
        }

        return $this->getHttpJsonResponse($jsonResponse);
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

    /**
     * @param $id
     * @Template("FrontendBundle:Commons:cart-item-details.html.twig")
     *
     * @return array
     */
    public function cartItemDetailsAction($id)
    {
        $em = $this->getEntityManager();
        $item = $em->getRepository('ItemBundle:Item')->findOneById($id);

        return array('item' => $item);
    }
}