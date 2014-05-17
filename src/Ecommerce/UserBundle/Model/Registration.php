<?php
namespace Ecommerce\UserBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Ecommerce\UserBundle\Entity\User;

class Registration
{
    /**
     * @Assert\Type(type="Ecommerce\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $policyAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (boolean)$termsAccepted;
    }

    public function setPolicyAccepted($policyAccepted)
    {
        $this->policyAccepted = $policyAccepted;
    }

    public function getPolicyAccepted()
    {
        return $this->policyAccepted;
    }
}