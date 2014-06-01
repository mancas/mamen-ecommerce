<?php

namespace Ecommerce\LocationBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Ecommerce\UserBundle\Entity\Address;
use Ecommerce\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class NewAddressHandler
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function handle(FormInterface $form, Request $request, User $user)
    {
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $address = $form->getData();
                $address->setUser($user);
                $city = $request->request->get('c');
                if (isset($city)) {
                    $city = $this->em->getRepository('LocationBundle:City')->findOneById($city);
                    $address->setCity($city);
                }
                $this->em->persist($address);
                $this->em->flush();

                return true;
            }
        }

        return false;
    }
}