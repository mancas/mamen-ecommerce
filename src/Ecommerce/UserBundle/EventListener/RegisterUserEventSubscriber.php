<?php

namespace Ecommerce\UserBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ecommerce\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class RegisterUserEventSubscriber implements EventSubscriber
{
    private $encoderFactory;

    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function getSubscribedEvents()
    {
        return array('prePersist');
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if(!$entity instanceof User) {
            return;
        }
        $this->createSalt($entity);
        $this->generateValidateCode($entity);
    }

    private function createSalt(User $user)
    {
        if (!$user->getSalt()) {
            $user->setSalt(md5(time() . User::AUTH_SALT));
            $encoder = $this->encoderFactory->getEncoder($user);
            $passwordEncoded = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($passwordEncoded);
        }
    }

    public function generateValidateCode(User $user)
    {
        $validateCode = substr(md5($user->getPassword() . User::AUTH_SALT), 0, 4);
        $user->setValidatedCode($validateCode);
    }

}
