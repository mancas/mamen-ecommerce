<?php

namespace Ecommerce\BackendBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('required' => false))
            ->add('category', 'entity',
                array(
                    'class' => 'CategoryBundle:Category',
                    'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                        },
                    'required' => false
                )
            );
    }

    public function getName()
    {
        return 'form_search_item';
    }
}
