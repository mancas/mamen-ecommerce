<?php

namespace Ecommerce\OrderBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\OrderBundle\Entity\Order;
use Ecommerce\OrderBundle\Entity\OrderItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends CustomController
{
    public function newOrderAction(Request $request)
    {
        $em = $this->getEntityManager();
        $user = $this->getCurrentUser();
        $cartStorageManager = $this->getCartStorageManager();
        $cart = $cartStorageManager->getCurrentCart();
        $deliveryCost = Order::DELIVERY_COST;
        $deliveryHome = Order::DELIVERY_HOME;
        $takeInPlace = Order::TAKE_IN_PLACE;

        if ($request->isMethod('POST')) {
            $data = $request->request;
            $address = null;
            if ($request->get('delivery_options') == $deliveryHome) {
                $address = $em->getRepository('LocationBundle:Address')->findOneById($data->get('delivery_address'));
            }

            $order = new Order();
            $order->setAddress($address);
            if ($data->get('present'))
                $order->setIsPresent(true);

            $cartItems = $cart->getCartItems();

            foreach ($cartItems as $cartItem) {
                $item = $em->getRepository('ItemBundle:Item')->findOneBy(array('id' => $cartItem->getId()));
                $orderItem = new OrderItem();
                $orderItem->setItem($item);
                $orderItem->setOrder($order);
                $orderItem->setQuantity($cartItem->getQuantity());
                $orderItem->setPrice($item->getPrice());
                $order->addItem($orderItem);
                $em->persist($orderItem);
            }

            $order->setCustomer($user);
            $order->setDate(new \DateTime('now'));
            $order->setStatus(Order::STATUS_READY);

            $em->persist($order);
            $em->flush();
        }
        return $this->render('OrderBundle:Order:new-order.html.twig', array('cart' => $cart,
                                                                            'user' => $user,
                                                                            'delivery_cost' => $deliveryCost,
                                                                            'take_in_place' => $takeInPlace,
                                                                            'delivery_home' => $deliveryHome));
    }
}
