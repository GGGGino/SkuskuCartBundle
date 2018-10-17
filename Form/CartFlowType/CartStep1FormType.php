<?php

namespace GGGGino\SkuskuCartBundle\Form\CartFlowType;

use GGGGino\SkuskuCartBundle\Form\CartProductType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartStep1FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cartProducts', CollectionType::class, array(
            'entry_type' => CartProductType::class,
            'label' => false,
            'attr' => array(
                'class' => 'step1'
            )
        ))
        ->add('getTotalQuantity', null, array(
            'disabled' => true
        ))
        ->add('getTotalPrice', null, array(
            'disabled' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    public function getBlockPrefix()
    {
        return 'cartStep1';
    }
}