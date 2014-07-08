<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\ItemBundle\Entity\Delivery;
use Ecommerce\ItemBundle\Form\Type\DeliveryType;
use Ecommerce\ItemBundle\Form\Type\ManufacturerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\ItemBundle\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Request;

class DeliveryController extends CustomController
{
    public function listAction(Request $request)
    {
        $em = $this->getEntityManager();
        $deliveryOptions = $em->getRepository("ItemBundle:Delivery")->findAll();

        return $this->render('BackendBundle:Delivery:list.html.twig', array('deliveryOptions' => $deliveryOptions));
    }

    /**
     * @ParamConverter("delivery", class="ItemBundle:Delivery")
     */
    public function editAction(Delivery $delivery, Request $request)
    {
        $form = $this->createForm(new DeliveryType(), $delivery);
        $handler = $this->get('delivery.delivery_form_handler');

        if ($handler->handle($form, $request)) {
            $this->setTranslatedFlashMessage('Se ha modificado la opción de envío');

            return $this->redirect($this->generateUrl('admin_delivery_index'));
        }

        return $this->render('BackendBundle:Delivery:create.html.twig', array('edition' => true, 'deliveryOption' => $delivery, 'form' => $form->createView()));
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
        $deliveryOption = new Delivery();
        $form = $this->createForm(new DeliveryType(), $deliveryOption);
        $handler = $this->get('delivery.delivery_form_handler');

        if ($handler->handle($form, $request)) {
            $this->setTranslatedFlashMessage('Se ha creado la opción de envío correctamente');

            return $this->redirect($this->generateUrl('admin_delivery_index'));
        }

        return $this->render('BackendBundle:Delivery:create.html.twig', array('form' => $form->createView()));
    }
}