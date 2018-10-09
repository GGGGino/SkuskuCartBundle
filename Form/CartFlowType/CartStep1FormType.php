<?php

namespace GGGGino\SkuskuCartBundle\Form\CartFlowType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartStep1FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $validValues = array(2, 4);
        $builder->add('numberOfWheels', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'choices' => array_combine($validValues, $validValues),
            'placeholder' => '',
            'attr' => array(
                'class' => 'form-horizontal'
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('attr', array(
            'class' => 'form-group'
        ));
        //var_dump($resolver);exit;
    }

    public function getBlockPrefix()
    {
        return 'cartStep1';
    }
}