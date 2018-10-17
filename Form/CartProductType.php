<?php

namespace GGGGino\SkuskuCartBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', null, array(
                'attr' => array(
                    'readonly' => true,
                )
            ))
            ->add('quantity', IntegerType::class,
                array(
                    'label' => 'quantity'
                ))
            ->add('getSubtotal', null, array(
                'disabled' => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct',
            'label' => false
        ));
    }
}