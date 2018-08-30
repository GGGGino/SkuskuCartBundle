<?php

namespace GGGGino\SkuskuCartBundle\Form\CartFlowType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CartStep2FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('engine', 'MyCompany\MyBundle\Form\Type\VehicleEngineType', array(
            'placeholder' => 'bla',
        ));
    }

    public function getBlockPrefix()
    {
        return 'cartStep1';
    }
}