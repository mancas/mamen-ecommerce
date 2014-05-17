<?php

namespace Ecommerce\UserBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\UserBundle\Event\UserEvent;
use Ecommerce\UserBundle\Event\UserEvents;
use Ecommerce\UserBundle\Form\Type\RegistrationType;
use Ecommerce\UserBundle\Form\Type\ValidatedCodeType;
use Ecommerce\UserBundle\Model\Registration;
use Symfony\Component\HttpFoundation\Request;

class AccessController extends CustomController
{
    public function loginAction()
    {
        return $this->render('FrontendBundle:Commons:login.html.twig');
    }

    public function registerAction(Request $request)
    {
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration);
        $handler = $this->get('user.register_user_form_handler');
        if ($handler->handle($form, $request)) {
            $user = $registration->getUser();
            $userEvent = new UserEvent($user);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(UserEvents::NEW_USER, $userEvent);

            return $this->redirect($this->generateUrl('success_register'));
        }

        return $this->render('UserBundle:Access:register.html.twig', array('form' => $form->createView()));
    }

    public function successRegisterAction()
    {
        $form = $this->createForm(new ValidatedCodeType());

        return $this->render('UserBundle:Access:success-register.html.twig', array('user' => $this->get('security.context')->getToken()->getUser(), 'form' => $form->createView()));
    }

    public function validateUserAction(Request $request)
    {
        
    }
}
