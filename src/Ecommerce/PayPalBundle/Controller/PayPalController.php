<?php
namespace Ecommerce\PayPalBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PayPalController extends CustomController
{
    /**
     * @ParamConverter("$order", class="OrderBundle:Order")
     */
    public function payWithPayPalAction(Order $order)
    {
        $em = $this->getEntityManager();
        $user = $this->getCurrentUser();
        $paypal = $this->get('paypal');

        $paymentAmount = urlencode(round($order->getTotalAmount(), 2));
        $desc = urlencode($this->get('translator')->trans(Order::PAYPAL_DESC));

        $urlAccept = $this->generateUrl('paypal_pay_correct', array('id' => $order->getId()), true);
        $urlCancel = $this->generateUrl('paypal_pay_denied', array('id' => $order->getId()), true);

        $response = $paypal->pay($paymentAmount, $desc, $urlAccept, $urlCancel);
        $url = $response['url'];

        return $this->redirect($url);
    }

    /**
     * @ParamConverter("$order", class="OrderBundle:Order")
     */
    public function payCorrectAction(Order $order, Request $request)
    {
        ldd('ok');
        $em = $this->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $payerId = $request->query->get('PayerID');
        $token = $request->query->get('token');
        $result = false;
        /*if ($user->isEqualTo($booking->getUser())) {
            $this->get('booking.manager')->saveBookingPayPal($booking, $payerId, $token);
            $this->get('bill.manager')->createBill($booking->getPayment());
            $this->get('contract.manager')->createContract($booking->getPayment());
            $bookingEvent = new BookingEvent($booking, true);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(BookingEvents::BOOKING_STATE_CHANGED, $bookingEvent);
            $result = true;
        }*/

        return $this->render('PayPalBundle:PayPal:success.html.twig', array('result' => $result));
    }

    /**
     * @ParamConverter("$order", class="OrderBundle:Order")
     */
    public function payDeniedAction(Order $order)
    {
        ldd('bad');
        return $this->render('PayPalBundle:PayPal:wrong.html.twig');
    }
}