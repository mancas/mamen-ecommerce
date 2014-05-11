<?php

namespace Ecommerce\CategoryBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubcategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('category', 'entity', array(
                        'class' => 'CategoryBundle:Category',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                        },
                        'expanded' => false,
                        'required' => true
                    ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Ecommerce\CategoryBundle\Entity\Subcategory',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'subcategory';
    }
}