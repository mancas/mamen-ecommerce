<?php

namespace Ecommerce\PayPalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\PaymentBundle\Entity\Payment;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class PaypalPayment extends Payment
{
    /**
     * @ORM\Column(name="tokenPayPal", type="string", length=255, nullable=true)
     *
     */
    private $tokenPayPal;

    /**
     * @ORM\Column(name="PayerId", type="string", length=255, nullable=true)
     */
    private $payerId;

    public function getTokenPayPal()
    {
        return $this->tokenPayPal;
    }

    public function setTokenPayPal($tokenPayPal)
    {
        $this->tokenPayPal = $tokenPayPal;
    }

    public function getPayerId()
    {
        return $this->payerId;
    }

    public function setPayerId($payerId)
    {
        $this->payerId = $payerId;
    }

}