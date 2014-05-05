<?php

namespace Ecommerce\ItemBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('required' => true))
                ->add('description', 'textarea', array('required' => true))
                ->add('price', 'number', array('required' => true))
                ->add('category', 'entity',
                        array(
                            'class' => 'CategoryBundle:Category',
                            'query_builder' => function (EntityRepository $er) {
                                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                                }, 'expanded' => false
                        )
                    )
                ->add('stock', 'number', array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Ecommerce\ItemBundle\Entity\Item',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'item';
    }
}