<?php

namespace Ecommerce\CategoryBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubcategorySearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', 'entity', array(
                'class' => 'CategoryBundle:Category',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                    },
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'subcategory_search';
    }
}