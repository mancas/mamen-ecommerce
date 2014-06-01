<?php

namespace Ecommerce\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends CustomController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $orders = $em->getRepository('OrderBundle:Order')->findOrdersResume();

        return $this->render('BackendBundle:Backend:index.html.twig', array('data' => $orders));
    }
}
