<?php

namespace GGGGino\SkuskuCartBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;

/**
 *
 *
 * Class CartFlowBase
 * @package GGGGino\SkuskuCartBundle\Form
 */
abstract class CartFlowBase extends FormFlow
{
    /**
     * @var array
     */
    protected $configSteps;

    public function __construct(array $configSteps)
    {
        $this->configSteps = $configSteps;
    }

    /**
     * @inheritdoc
     */
    protected function loadStepsConfig()
    {
        return $this->configSteps;
    }
}