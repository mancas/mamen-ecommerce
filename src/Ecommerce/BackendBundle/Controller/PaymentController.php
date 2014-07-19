<?php

namespace Ecommerce\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Ecommerce\FrontendBundle\Controller\CustomController;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends CustomController
{
    public function listAction()
    {
        $em = $this->getEntityManager();
        $payments = $em->getRepository('PaymentBundle:Payment')->findAll();
        $paymentsThisMonth = $em->getRepository('PaymentBundle:Payment')->findPaymentsByMonth(new \DateTime('now'));
        $totalAmount = 0.0;
        foreach ($payments as $payment) {
            $totalAmount += $payment->getTotal();
        }

        return $this->render('BackendBundle:Payment:list.html.twig', array('payments' => $payments, 'totalAmount' => $totalAmount));
    }
}
