<?php

namespace Ecommerce\UserBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\UserBundle\Entity\User;
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
        $form = $this->createForm(new ValidatedCodeType());
        $form->handleRequest($request);
        $user = $this->getCurrentUser();
        if ($form->isValid()) {
            $code = $form->get('code')->getData();

            if ($user instanceof User && $user->getValidatedCode() == $code) {
                $em = $this->getEntityManager();
                $user->setValidated(true);
                $em->persist($user);
                $em->flush();
                $this->setTranslatedFlashMessage('Tu cuenta ha sido validada, ya puedes acceder a tu perfil y configurar tus datos.');

                return $this->redirect($this->generateUrl('frontend_homepage'));
            } else {
                $this->setTranslatedFlashMessage('El código introducido no coincide con el que te hemos mandado.', 'error');
            }
        }

        return $this->render('UserBundle:Access:validate-code.html.twig', array('form' => $form->createView(), 'user' => $user));
    }

    public function checkIfEmailIsAvailableAction(Request $request)
    {
        $jsonResponse = json_encode(array('available' => 'false'));
        if ($request->isXmlHttpRequest()) {
            $form = $request->query->get('registration');

            $email = current($form['user']['email']);

            if ($this->checkEmailAvailable($email)) {
                $jsonResponse = json_encode(array('available' => 'true'));
            }
        }

        return $this->getHttpJsonResponse($jsonResponse);
    }

    private function checkEmailAvailable($email)
    {
        $em = $this->getEntityManager();
        $user = $em->getRepository('UserBundle:User')->findOneByEmail($email);

        return !($user instanceof User);
    }
}
