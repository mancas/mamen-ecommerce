<?php

namespace Ecommerce\UserBundle\EventListener;

use Ecommerce\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Ecommerce\UserBundle\Event\UserEvents;
use Ecommerce\UserBundle\Event\UserEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;

class AutoLoginUserListener implements EventSubscriberInterface
{
    private $securityContext;

    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::NEW_USER => 'onNewUser'
        );
    }

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function onNewUser(UserEvent $event)
    {
        $this->createToken($event->getUser());
    }

    private function createToken(User $user)
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'user', $user->getRoles());
        $this->securityContext->setToken($token);
    }

}