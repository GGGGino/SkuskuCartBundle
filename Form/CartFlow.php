<?php

namespace GGGGino\SkuskuCartBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;

class CartFlow extends FormFlow
{
    protected function loadStepsConfig()
    {
        return array(
            array(
                'label' => 'cart',
                'form_type' => 'GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep1FormType',
            ),
            array(
                'label' => 'chosePayment',
                'form_type' => 'GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep2FormType',
            ),
            array(
                'label' => 'payment',
                'form_type' => 'GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep3FormType'
            ),
            array(
                'label' => 'confirmation',
            ),
        );
    }
}