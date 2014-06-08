<?php

namespace Ecommerce\BackendBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\LocationBundle\Form\Type\AddressDataBillingType;
use Ecommerce\PaymentBundle\Entity\DataBilling;
use Ecommerce\PaymentBundle\Form\Type\DataBillingType;

class DataBillingController extends CustomController
{
    public function indexAction()
    {
        $admin = $this->getCurrentUser();
        $em = $this->getEntityManager();

        $dataBilling = $em->getRepository('PaymentBundle:DataBilling')->findOneById(1);
        if (!$dataBilling) {
            $dataBilling = new DataBilling();
        }

        $form = $this->createForm(new DataBillingType(), $dataBilling);
        $addressForm = $this->createForm(new AddressDataBillingType(), $dataBilling->getAddress());

    }
}