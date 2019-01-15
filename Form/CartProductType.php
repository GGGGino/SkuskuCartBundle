<?php

namespace GGGGino\SkuskuCartBundle\Form;

use GGGGino\SkuskuCartBundle\Form\Type\SkuskuProductButtonsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class, array(
                'label' => 'product',
                'attr' => array(
                    'readonly' => true,
                )
            ))
            ->add('product', TextType::class, array(
                'label' => 'product',
                'attr' => array(
                    'readonly' => true,
                )
            ))
            ->add('quantity', IntegerType::class, array(
                'label' => 'quantity'
            ))
            ->add('getProductPrice', MoneyType::class, array(
                'label' => 'price',
                'disabled' => true
            ))
            ->add('getSubtotal', MoneyType::class, array(
                'label' => 'subtotal',
                'disabled' => true
            ))
            ->add('buttons', SkuskuProductButtonsType::class, array(
                'label' => 'actions',
                'mapped' => false,
                'attr' => array('class' => 'delete'),
            ));

        $builder->addEventListener(FormEvents::POST_SET_DATA, function ($event) {
            //var_dump($event->getData());exit; //Return NULL for embedded forms, and the entity for non-embedded forms
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct',
            'label' => false
        ));
    }
}