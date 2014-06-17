<?php

namespace Ecommerce\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CustomController extends Controller
{
    protected function getHttpJsonResponse($jsonResponse)
    {
        $response = new \Symfony\Component\HttpFoundation\Response($jsonResponse);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    protected function setTranslatedFlashMessage($message, $class = 'info')
    {
        $translatedMessage = $this->get('translator')->trans($message);
        $this->get('session')->getFlashBag()->set($class, $translatedMessage);
    }

    protected function getTranslatedMessage($message)
    {
        return $this->get('translator')->trans($message);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function getCriteriaFromSearchForm($form)
    {
        $criteria = array();
        if ($form->isValid()) {
            $criteria = $form->getData();
        }

        return $criteria;
    }

    protected function getCurrentUser()
    {
        return $this->get('security.context')->getToken()->getUser();
    }

    protected function getCartStorageManager()
    {
        return $this->get('cart.cart_storage_manager');
    }

    protected function renderLoginTemplate($template, Request $request)
    {
        $session = $request->getSession();
        $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR, $session->get(SecurityContext::AUTHENTICATION_ERROR));

        return $this->render($template, array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error));
    }
}