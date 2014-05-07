<?php

namespace Ecommerce\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Ecommerce\CategoryBundle\Entity\Category;

class CategoryFormHandler
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
            $useInIndex = $request->request->get('category_index');
            if ($form->isValid()) {
                $category = $form->getData();
                if ($useInIndex)
                    $category->setUseInIndex(true);
                $this->em->persist($category);
                $this->em->flush();
                return true;
            }
        }

        return false;
    }
}