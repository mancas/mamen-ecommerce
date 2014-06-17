<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\LocationBundle\Form\Type\AddressDataBillingType;
use Ecommerce\PaymentBundle\Entity\DataBilling;
use Ecommerce\PaymentBundle\Form\Type\DataBillingType;
use Proxies\__CG__\Ecommerce\LocationBundle\Entity\Address;
use Symfony\Component\HttpFoundation\Request;

class DataBillingController extends CustomController
{
    public function indexAction(Request $request)
    {
        $admin = $this->getCurrentUser();
        $em = $this->getEntityManager();

        $dataBilling = $em->getRepository('PaymentBundle:DataBilling')->findBusinessDataBilling();
        if (count($dataBilling) == 0) {
            $dataBilling = new DataBilling();
            $dataBilling->setAddress(new Address());
            $provinceDataBilling = null;
            $cityDataBilling = null;
        } else {
            $dataBilling = $dataBilling[0];
            $provinceDataBilling = $dataBilling->getAddress()->getCity()->getProvince();
            $cityDataBilling = $dataBilling->getAddress()->getCity();
        }

        $form = $this->createForm(new DataBillingType(), $dataBilling);
        $addressForm = $this->createForm(new AddressDataBillingType(), $dataBilling->getAddress());
        $provinces = $em->getRepository('LocationBundle:Province')->findAll();

        $handler = $this->get('payment.databilling_form_handler');

        if ($handler->handle($form, $addressForm, $request)) {
            $this->setTranslatedFlashMessage("La dirección de facturación se ha guardado correctamente");
            return $this->redirect($this->generateUrl('admin_billing_settings_index'));
        }


        return $this->render('BackendBundle:DataBilling:index.html.twig', array('form' => $form->createView(),
                                                                                'addressForm' => $addressForm->createView(),
                                                                                'provinces' => $provinces,
                                                                                'provinceDataBilling' => $provinceDataBilling,
                                                                                'cityDataBilling' => $cityDataBilling));
    }
}