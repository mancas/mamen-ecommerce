<?php

namespace Ecommerce\UserBundle\EventListener;

use Ecommerce\UserBundle\Entity\User;
use Ecommerce\UserBundle\Event\UserEvent;
use Ecommerce\UserBundle\Event\UserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Routing\Router;

class SendActivationEmailListener implements EventSubscriberInterface
{
    private $mailer;
    private $templating;
    private $router;
    private $noreply;

    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::NEW_USER => 'onNewUser'
        );
    }

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, Router $router, $noreply)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->noreply = $noreply;
    }

    public function onNewUser(UserEvent $event)
    {
        $this->sendActivationEmail($event->getUser());
    }

    public function onRecoverPassword(UserEvent $event)
    {
        $this->sendRecoveryPassEmail($event->getUser());
    }

    private function sendActivationEmail(User $user)
    {
        $url = $this->router->generate('login',
            array(), true);

        $messageBody = $this->templating->render('UserBundle:Email:validation.html.twig',
            array('url' => $url, 'code' => $user->getValidatedCode()));
        $from = $this->noreply;

        $message = \Swift_Message::newInstance()
            ->setSubject('Bienvenido')
            ->setFrom($from)
            ->setTo($user->getEmail())
            ->setBody($messageBody, 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \Exception("Error en el envío del correo de activación");
        }
    }

    /*private function sendRecoveryPassEmail(User $user)
    {
        $url = $this->router->generate('new_password',
            array('data' => $user->getSalt()), true);
        $from = $this->noreply;
        $to = $user->getEmail();
        $messageBody = $this->templating->render(
            'UserBundle:Email:emailForgetPassword.html.twig',
            array('url' => $url));
        $message = \Swift_Message::newInstance()
            ->setSubject('Restablecer contraseña en CornerFy')
            ->setFrom($from)
            ->setTo($to)
            ->setBody($messageBody, 'text/html');
        if (!$this->mailer->send($message)) {
            throw new \Exception("Error en el envío del correo para olvido de contraseña");
        }
    }*/

}