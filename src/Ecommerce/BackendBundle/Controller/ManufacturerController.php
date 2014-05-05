<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\ItemBundle\Form\Type\ManufacturerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\ItemBundle\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Request;

class ManufacturerController extends CustomController
{
    public function listAction(Request $request)
    {
        $em = $this->getEntityManager();
        $manufacturers = $em->getRepository("ItemBundle:Manufacturer")->findAll();

        return $this->render('BackendBundle:Manufacturer:list.html.twig', array('manufacturers' => $manufacturers));
    }

    /**
     * @ParamConverter("manufacturer", class="ItemBundle:Manufacturer")
     */
    public function editAction(Manufacturer $manufacturer, Request $request)
    {
        $form = $this->createForm(new ManufacturerType(), $manufacturer);
        $handler = $this->get('manufacturer.manufacturer_form_handler');

        if ($handler->handle($form, $request)) {
            $this->setTranslatedFlashMessage('Se ha modificado el fabricante');

            return $this->redirect($this->generateUrl('admin_manufacturer_index'));
        }

        return $this->render('BackendBundle:Manufacturer:create.html.twig', array('edition' => true, 'manufacturer' => $manufacturer, 'form' => $form->createView()));
    }

    /**
     * @ParamConverter("manufacturer", class="ItemBundle:Item")
     */
    public function deleteAction(Manufacturer $manufacturer)
    {
        $em = $this->getEntityManager();
        $em->remove($manufacturer);
        $em->flush();

        $this->setTranslatedFlashMessage('Se ha eliminado el fabricante y todos sus productos');

        return $this->redirect($this->generateUrl('admin_manufacturer_index'));
    }

    public function createAction(Request $request)
    {
        $manufacturer = new Manufacturer();
        $form = $this->createForm(new ManufacturerType(), $manufacturer);
        $handler = $this->get('manufacturer.manufacturer_form_handler');

        if ($handler->handle($form, $request)) {
            $this->setTranslatedFlashMessage('Se ha creado el fabricante correctamente');

            return $this->redirect($this->generateUrl('admin_manufacturer_edit'));
        }

        return $this->render('BackendBundle:Manufacturer:create.html.twig', array('form' => $form->createView()));
    }
}