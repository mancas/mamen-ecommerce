<?php
namespace Ecommerce\PaymentBundle\Form\Handler;

use Ecommerce\LocationBundle\Entity\Address;
use Ecommerce\PaymentBundle\Entity\DataBilling;
use Doctrine\ORM\EntityManager;

class DataBillingManager
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveDataBilling(DataBilling $dataBilling, Address $address)
    {
        $this->entityManager->persist($dataBilling);
        $this->entityManager->persist($address);
        $this->entityManager->flush();
    }

}