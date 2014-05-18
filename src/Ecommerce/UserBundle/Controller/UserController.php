<?php

namespace Ecommerce\UserBundle\Controller;

use Ecommerce\FrontendBundle\Controller\CustomController;
use Ecommerce\UserBundle\Entity\User;
use Ecommerce\UserBundle\Form\Type\UserProfileType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends CustomController
{
    public function profileAction()
    {
        $user = $this->getCurrentUser();
        $form = $this->createForm(new UserProfileType(), $user);
        return $this->render('UserBundle:User:profile.html.twig', array('user' => $user, 'form' => $form->createView()));
    }

    /**
     * @param User $user
     * @Template("UserBundle:Commons:addressList.html.twig")
     *
     * @return array
     */
    public function adressListAction(User $user)
    {
        $em = $this->getEntityManager();
        $addresses = $em->getRepository('UserBundle:Address')->findAddressesByUser($user);
        return array('addresses' => $addresses);
    }
}
