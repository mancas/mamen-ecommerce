<?php

namespace Ecommerce\FrontendBundle\Controller;


class FrontendController extends CustomController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $categories = $em->getRepository('CategoryBundle:Category')->findCategoriesDQL();
        return $this->render('FrontendBundle:Pages:home.html.twig', array('categories' => $categories));
    }
}
