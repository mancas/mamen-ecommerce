<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\BackendBundle\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;
use Symfony\Component\HttpFoundation\Request;
use Ecommerce\CategoryBundle\Entity\Category;

class CategoryController extends CustomController
{
    public function listAction()
    {
        $em = $this->getEntityManager();
        $categories = $em->getRepository('CategoryBundle:Category')->findAll();

        return $this->render('BackendBundle:Category:list.html.twig', array('categories' => $categories));
    }

    /**
     * @ParamConverter("category", class="CategoryBundle:Category")
     */
    public function editAction(Category $category, Request $request)
    {
        $form = $this->createForm(new CategoryType(), $category);
        $handler = $this->get('category.category_form_handler');

        if ($handler->handle($form, $request)) {
            $this->setTranslatedFlashMessage('Se ha modificado la categoría');

            return $this->redirect($this->generateUrl('admin_category_index'));
        }

        return $this->render('BackendBundle:Category:create.html.twig', array('edit' => true, 'form' => $form->createView()));
    }

    /**
     * @ParamConverter("category", class="CategoryBundle:Category")
     */
    public function deleteAction(Category $category)
    {
        $em = $this->getEntityManager();
        $em->remove($category);
        $em->flush();

        $this->setTranslatedFlashMessage('Se ha eliminado la categoría');

        return $this->redirect($this->generateUrl('admin_category_index'));
    }

    public function createAction(Request $request)
    {
        $form = $this->createForm(new CategoryType());
        $handler = $this->get('category.category_form_handler');

        if ($handler->handle($form, $request)) {
            $this->setTranslatedFlashMessage('Se ha creado la categoría correctamente');

            return $this->redirect($this->generateUrl('admin_category_index'));
        }

        return $this->render('BackendBundle:Category:create.html.twig', array('edit' => false, 'form' => $form->createView()));
    }
}
