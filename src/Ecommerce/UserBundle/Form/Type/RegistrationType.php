<?php
namespace Ecommerce\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', new UserType())
                ->add('terms','checkbox', array('property_path' => 'termsAccepted'))
                ->add('policy', 'checkbox', array('property_path' => 'policyAccepted'));
    }

    public function getName()
    {
        return 'registration';
    }
}