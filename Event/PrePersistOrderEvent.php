<?php

namespace GGGGino\SkuskuCartBundle\Event;

use Craue\FormFlowBundle\Event\FormFlowEvent;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuOrder;
use GGGGino\SkuskuCartBundle\Model\SkuskuPayment;

/**
 * Class PrePersistOrderEvent
 * @package GGGGino\SkuskuCartBundle\Event
 */
class PrePersistOrderEvent extends FormFlowEvent
{
    /**
     * @var SkuskuOrder
     */
    private $order;

    /**
     * @param FormFlowInterface $flow
     * @param SkuskuOrder $order
     */
    public function __construct(FormFlowInterface $flow, SkuskuOrder $order)
    {
        parent::__construct($flow);
        $this->order = $order;
    }

    /**
     * @return SkuskuOrder
     */
    public function getOrder()
    {
        return $this->order;
    }
}
