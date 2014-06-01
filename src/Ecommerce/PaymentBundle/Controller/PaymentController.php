<?php

namespace Ecommerce\PaymentBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;

class PaymentController extends CustomController
{
    public function buyAction()
    {
        $em = $this->getEntityManager();
        $user = $this->getCurrentUser();
        $cartManager = $this->getCartStorageManager();
        $cart = $cartManager->getCurrentCart();
        $cartItems = $cart->getItems();

        foreach ($cartItems as $cartItem) {
            $item = $em->getRepository('ItemBundle:Item')->findOneBy(array('id' => $cartItem->getId()));
        }

        return $this->render('PaymentBundle:Default:index.html.twig');
    }
}
