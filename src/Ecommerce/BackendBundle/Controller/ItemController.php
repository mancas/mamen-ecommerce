<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\ItemBundle\Form\Type\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;

class ItemController extends CustomController
{
    public function listAction()
    {
        $em = $this->getEntityManager();
        $items = $em->getRepository('ItemBundle:Item')->findAll();

        return $this->render('BackendBundle:Item:list.html.twig', array('items' => $items));
    }

    /**
     * @ParamConverter("item", class="ItemBundle:Item")
     */
    public function viewAction(Item $item, Request $request)
    {
        return $this->render('BackendBundle:Item:view.html.twig', array('item' => $item));
    }

    /**
     * @ParamConverter("item", class="ItemBundle:Item")
     */
    public function editAction(Item $item, Request $request)
    {
        $form = $this->createForm(new ItemType(), $item);
        $handler = $this->get('item.item_form_handler');

        if ($handler->handle($form, $request)) {
            $this->setTranslatedFlashMessage('Se ha modificado el producto');

            $this->redirect($this->generateUrl('admin_item_index'));
        }

        return $this->render('BackendBundle:Item:create.html.twig', array('edit' => true, 'form' => $form->createView()));
    }

    /**
     * @ParamConverter("item", class="ItemBundle:Item")
     */
    public function deleteAction(Item $item)
    {
        $em = $this->getEntityManager();
        $em->remove($item);
        $em->flush();

        $this->setTranslatedFlashMessage('Se ha eliminado el producto');

        $this->redirect($this->generateUrl('admin_item_index'));
    }

    public function createAction(Request $request)
    {
        $form = $this->createForm(new ItemType());
        $handler = $this->get('item.item_form_handler');

        if ($handler->handle($form, $request)) {
            $this->setTranslatedFlashMessage('Se ha creado el producto correctamente');

            $this->redirect($this->generateUrl('admin_item_index'));
        }

        return $this->render('BackendBundle:Item:create.html.twig', array('edit' => false, 'form' => $form->createView()));
    }
}