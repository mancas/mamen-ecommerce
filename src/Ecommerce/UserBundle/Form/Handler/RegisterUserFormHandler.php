<?php

namespace Ecommerce\UserBundle\Form\Handler;

use Ecommerce\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class RegisterUserFormHandler
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function handle(FormInterface $form, Request $request)
    {
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $registration = $form->getData();
                $this->userManager->saveUser($registration->getUser());
                return true;
            }
        }

        return false;
    }
}