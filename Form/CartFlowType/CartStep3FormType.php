<?php

namespace GGGGino\SkuskuCartBundle\Form\CartFlowType;

use Craue\FormFlowBundle\Form\FormFlowInterface;
use Payum\Core\Bridge\Symfony\Form\Type\CreditCardType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CartStep3FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('engine', CreditCardType::class, array(
            'mapped' => false
        ));
    }

    public function getBlockPrefix()
    {
        return 'cartStep3';
    }
}