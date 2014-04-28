<?php

namespace Ecommerce\OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OrderBundle:Default:index.html.twig', array('name' => $name));
    }
}
