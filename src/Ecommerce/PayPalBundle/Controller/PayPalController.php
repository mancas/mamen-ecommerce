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
     * @ParamConverter("$booking", class="BookingBundle:Booking")
     */
    public function payCorrectAction(Booking $booking)
    {
        $em = $this->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $req = $this->getRequest();
        $payerId = $req->query->get('PayerID');
        $token = $req->query->get('token');
        $result = false;
        if ($user->isEqualTo($booking->getUser())) {
            $this->get('booking.manager')->saveBookingPayPal($booking, $payerId, $token);
            $this->get('bill.manager')->createBill($booking->getPayment());
            $this->get('contract.manager')->createContract($booking->getPayment());
            $bookingEvent = new BookingEvent($booking, true);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(BookingEvents::BOOKING_STATE_CHANGED, $bookingEvent);
            $result = true;
        }

        return $this->render('PayPalBundle:PayPal:success.html.twig', array('result' => $result));
    }

    /**
     * @ParamConverter("$booking", class="BookingBundle:Booking")
     */
    public function payDeniedAction(Booking $booking)
    {
        return $this->render('PayPalBundle:PayPal:wrong.html.twig');
    }
}