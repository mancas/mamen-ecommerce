<?php

namespace Ecommerce\OrderBundle\EventListener;

use Ecommerce\OrderBundle\Entity\Order;
use Ecommerce\OrderBundle\Event\OrderEvent;
use Ecommerce\OrderBundle\Event\OrderEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Routing\Router;

class OrderEventListener implements EventSubscriberInterface
{
    private $mailer;
    private $templating;
    private $router;
    private $noreply;

    public static function getSubscribedEvents()
    {
        return array(
            OrderEvents::NEW_ORDER => 'onNewOrder',
            OrderEvents::STATUS_CHANGED => 'onStatusChanged'
        );
    }

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, Router $router, $noreply)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->noreply = $noreply;
    }

    public function onNewOrder(OrderEvent $event)
    {
        $this->sendNewOrderEmail($event->getOrder());
    }

    public function onStatusChanged(OrderEvent $event)
    {
        $this->sendStatusOrderEmail($event->getOrder());
    }

    private function sendNewOrderEmail(Order $order)
    {
        $messageBody = $this->templating->render('OrderBundle:Email:new-order.html.twig',
            array('order' => $order));
        $from = $this->noreply;

        $message = \Swift_Message::newInstance()
            ->setSubject('Se ha recibido correctamente el pedido')
            ->setFrom($from)
            ->setTo($order->getCustomer()->getEmail())
            ->setBody($messageBody, 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \Exception("Error en el envío de confirmación de pedido");
        }
    }

    private function sendStatusOrderEmail(Order $order)
    {
        $messageBody = $this->templating->render('OrderBundle:Email:new-order-status.html.twig',
            array('order' => $order));
        $from = $this->noreply;

        $message = \Swift_Message::newInstance()
            ->setSubject('Ha cambiado el estado de su pedido')
            ->setFrom($from)
            ->setTo($order->getCustomer()->getEmail())
            ->setBody($messageBody, 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \Exception("Error en el envío de estado de pedido");
        }
    }
}