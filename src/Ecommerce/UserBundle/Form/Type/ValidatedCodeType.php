<?php
namespace Ecommerce\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ValidatedCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', 'text', array('required' => true, 'attr' => array('placeholder' => 'Código de validación')));
    }

    public function getName()
    {
        return 'validate_user';
    }
}