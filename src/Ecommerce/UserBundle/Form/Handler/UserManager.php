<?php
namespace Ecommerce\UserBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Ecommerce\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserManager
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveUser(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}