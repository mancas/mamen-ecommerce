<?php

namespace Ecommerce\FrontendBundle\Controller;


class FrontendController extends CustomController
{
    public function indexAction()
    {
        return $this->render('FrontendBundle:Pages:home.html.twig');
    }
}
