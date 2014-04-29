<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\OrderBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;

class OrderController extends CustomController
{
    public function listAction()
    {
        $em = $this->getEntityManager();
        $orders = $em->getRepository('OrderBundle:Order')->findAll();

        return $this->render('BackendBundle:Order:list.html.twig', array('orders' => $orders));
    }

    /**
     * @ParamConverter("order", class="OrderBundle:Order")
     */
    public function viewAction(Order $order)
    {
        return $this->render('BackendBundle:Order:view.html.twig', array('order' => $order));
    }


    public function deleteItemAction($itemId, $orderId)
    {
        $em = $this->getEntityManager();
        $orderItem = $em->getRepository('OrderBundle:OrderItem')->findOneBy(array('order_id' => $orderId, 'item_id' => $itemId));

        if ($orderItem) {
            $em->remove($orderItem);
            $em->flush();

            $this->setTranslatedFlashMessage('Se ha eliminado el producto del pedido');
        }

        return $this->redirect($this->generateUrl('admin_order_view', array('id' => $orderId)));
    }

    /**
     * @ParamConverter("order", class="OrderBundle:Order")
     */
    public function markAsSentAction(Order $order)
    {
        $em = $this->getEntityManager();

        $order->setStatus(Order::STATUS_SEND);
        $em->persist($order);
        $em->flush();

        $this->setTranslatedFlashMessage('El pedido ha sido marcado como enviado');

        $this->redirect($this->generateUrl('admin_order_index'));
    }
}