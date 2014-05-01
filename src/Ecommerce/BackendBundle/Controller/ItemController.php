<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\BackendBundle\Form\Type\ItemSearchType;
use Ecommerce\ImageBundle\Form\Type\MultipleImageType;
use Ecommerce\ItemBundle\Form\Type\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\ItemBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends CustomController
{
    public function listAction(Request $request)
    {
        $em = $this->getEntityManager();
        $form = $this->createForm(new ItemSearchType());
        $form->submit($request);
        $criteria = $this->getCriteriaFromSearchForm($form);

        $items = $em->getRepository("ItemBundle:Item")->findBySearchCriteria($criteria)->getResult();

        return $this->render('BackendBundle:Item:list.html.twig', array('items' => $items, 'form' => $form->createView()));
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
        $imageForm = $this->createForm(new MultipleImageType());
        $handler = $this->get('item.item_form_handler');
        $imagesHandler = $this->get('image.form_handler');

        if ($handler->handle($form, $request)) {
            $imagesHandler->handleMultiple($imageForm, $request, $item);
            $this->setTranslatedFlashMessage('Se ha modificado el producto');

            return $this->redirect($this->generateUrl('admin_item_index'));
        }

        return $this->render('BackendBundle:Item:create.html.twig', array('edition' => true, 'item' => $item, 'form' => $form->createView(), 'formImage' => $imageForm->createView()));
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

        return $this->redirect($this->generateUrl('admin_item_index'));
    }

    public function createAction(Request $request)
    {
        $item = new Item();
        $form = $this->createForm(new ItemType(), $item);
        $imageForm = $this->createForm(new MultipleImageType());
        $handler = $this->get('item.item_form_handler');
        $imagesHandler = $this->get('image.form_handler');

        if ($handler->handle($form, $request)) {
            $imagesHandler->handleMultiple($imageForm, $request, $item);
            $this->setTranslatedFlashMessage('Se ha creado el producto correctamente');

            return $this->redirect($this->generateUrl('admin_item_index'));
        }

        return $this->render('BackendBundle:Item:create.html.twig', array('form' => $form->createView(), 'formImage' => $imageForm->createView()));
    }
}