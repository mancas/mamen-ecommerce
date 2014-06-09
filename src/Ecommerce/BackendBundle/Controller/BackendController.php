<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\FrontendBundle\Util\ArrayHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends CustomController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        list($orders, $ordersReadyToSend, $ordersReadyToTake, $users) = $this->getSiteStatistics();

        return $this->render('BackendBundle:Backend:index.html.twig', array('orders' => $orders,
                                                                            'ordersReadyToSend' => $ordersReadyToSend,
                                                                            'ordersReadyToTake' => $ordersReadyToTake,
                                                                            'users' => $users));
    }

    public function getRecentOrdersAction()
    {
        $em = $this->getEntityManager();
        $orders = $em->getRepository('OrderBundle:Order')->findOrdersResume();
        $response = $this->getArrayWithSevenDays();

        foreach ($orders as $orderResume) {
            $date = $orderResume['date'];
            $response[$date->format('d-m-Y')] += $orderResume['TotalOrders'];
        }

        $jsonResponse = json_encode($response);

        return $this->getHttpJsonResponse($jsonResponse);
    }

    private function getArrayWithSevenDays()
    {
        $response = array();

        for ($i = 7; $i >= 0; $i--) {
            $date = new \DateTime('now');
            $date->modify('-' . $i . ' days');
            $response[$date->format('d-m-Y')] = 0;
        }

        return $response;
    }

    private function getSiteStatistics()
    {
        $em = $this->getEntityManager();
        $orders = $em->getRepository('OrderBundle:Order')->findAll();
        $ordersReadyToSend = $em->getRepository('OrderBundle:Order')->findOrdersReadyToSend();
        $ordersReadyToTake = $em->getRepository('OrderBundle:Order')->findOrdersReadyToTake();
        $user = $em->getRepository('UserBundle:User')->findAll();

        return array(count($orders), count($ordersReadyToSend), count($ordersReadyToTake), count($user));
    }
}
