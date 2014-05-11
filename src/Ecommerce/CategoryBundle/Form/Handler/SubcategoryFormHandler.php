<?php

namespace Ecommerce\CategoryBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Ecommerce\CategoryBundle\Entity\Category;

class SubcategoryFormHandler
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function handle(FormInterface $form, Request $request)
    {
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $subcategory = $form->getData();
                $this->em->persist($subcategory);
                $this->em->flush();
                return true;
            }
        }

        return false;
    }
}