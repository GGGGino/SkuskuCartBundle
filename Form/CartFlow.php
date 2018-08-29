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
                'label' => 'wheels',
                'form_type' => 'GGGGino\SkuskuCartBundle\Form\CartType\CartStep1FormType',
            ),
            array(
                'label' => 'engine',
                'form_type' => 'GGGGino\SkuskuCartBundle\Form\CartType\CartStep2FormType',
                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    return $estimatedCurrentStepNumber > 1;
                },
            ),
            array(
                'label' => 'confirmation',
            ),
        );
    }
}