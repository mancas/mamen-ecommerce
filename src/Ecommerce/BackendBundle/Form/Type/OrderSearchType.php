<?php

namespace Ecommerce\BackendBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Ecommerce\OrderBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('from', 'date', array('widget' => 'single_text', 'required' => false, 'format' => 'dd-MM-yyyy'))
                ->add('to', 'date', array('widget' => 'single_text', 'required' => false, 'format' => 'dd-MM-yyyy'))
                ->add('payment', 'checkbox', array('required' => false))
                ->add('status', 'choice', array(
                'choices' => array(Order::STATUS_READY => Order::STATUS_READY, Order::STATUS_IN_PROCESS => Order::STATUS_IN_PROCESS, Order::STATUS_OUT_OF_STOCK => Order::STATUS_OUT_OF_STOCK,
                                    Order::STATUS_READY_TO_TAKE => Order::STATUS_READY_TO_TAKE, Order::STATUS_SEND => Order::STATUS_SEND),
                'empty_value' => 'Selecciona un estado',
                'required' => false
            ));
    }

    public function getName()
    {
        return 'form_search_order';
    }
}
