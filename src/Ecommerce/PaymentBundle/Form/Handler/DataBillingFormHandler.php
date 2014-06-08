<?php

namespace Ecommerce\PaymentBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Ecommerce\LocationBundle\Entity\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class DataBillingFormHandler
{
    private $dataBillingManager;
    private $em;

    public function __construct(DataBillingManager $dataBillingManager, EntityManager $em)
    {
        $this->dataBillingManager = $dataBillingManager;
        $this->em = $em;
    }

    public function handle(FormInterface $form, FormInterface $addressForm, Request $request)
    {
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $addressForm->handleRequest($request);
            if ($form->isValid() && $addressForm->isValid()) {
                $dataBilling = $form->getData();
                $address = $addressForm->getData();
                $city = $request->request->get('c');
                if (isset($city)) {
                    $city = $this->em->getRepository('LocationBundle:City')->findOneById($city);
                    $address->setCity($city);
                }
                $this->dataBillingManager->saveDataBilling($dataBilling, $address);
                return true;
            }
        }

        return false;
    }
}