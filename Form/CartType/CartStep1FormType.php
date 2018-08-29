<?php

namespace GGGGino\SkuskuCartBundle\Form\CartType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CartStep1FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $validValues = array(2, 4);
        $builder->add('numberOfWheels', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'choices' => array_combine($validValues, $validValues),
            'placeholder' => '',
        ));
    }

    public function getBlockPrefix()
    {
        return 'cartStep1';
    }
}