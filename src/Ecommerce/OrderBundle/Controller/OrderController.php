<?php

namespace Ecommerce\OrderBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\OrderBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends CustomController
{
    public function newOrderAction(Request $request)
    {
        $user = $this->getCurrentUser();
        $cartStorageManager = $this->getCartStorageManager();
        $cart = $cartStorageManager->getCurrentCart();
        $deliveryCost = Order::DELIVERY_COST;

        if ($request->isMethod('POST')) {
            ldd($request->request);
        }
        return $this->render('OrderBundle:Order:new-order.html.twig', array('cart' => $cart,
                                                                            'user' => $user,
                                                                            'delivery_cost' => $deliveryCost));
    }
}
