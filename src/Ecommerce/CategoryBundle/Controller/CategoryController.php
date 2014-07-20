<?php

namespace Ecommerce\CategoryBundle\Controller;

use Ecommerce\CategoryBundle\Entity\Subcategory;
use Ecommerce\FrontendBundle\Controller\CustomController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategoryController extends CustomController
{
    /**
     * @ParamConverter("subcategory", class="CategoryBundle:Subcategory")
     */
    public function viewSubcategoryAction(Subcategory $subcategory)
    {
        $em = $this->getEntityManager();
        $paginator = $this->get('ideup.simple_paginator');
        $paginator->setItemsPerPage(32, 'items');
        $items = $paginator->paginate($em->getRepository('ItemBundle:Item')->findItemsBySubcategoryDQL($subcategory), 'items')->getResult();

        return $this->render('CategoryBundle:Subcategory:list.html.twig', array('items' => $items, 'paginator' => $paginator, 'subcategory' => $subcategory));
    }
}
