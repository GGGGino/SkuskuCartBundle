<?php

namespace GGGGino\SkuskuCartBundle\Event;

use Craue\FormFlowBundle\Event\FormFlowEvent;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuPayment;

/**
 * Class PostPaymentCartEvent
 * @package GGGGino\SkuskuCartBundle\Event
 */
class PostPaymentCartEvent extends FormFlowEvent
{
    /**
     * @var SkuskuPayment
     */
    private $payment;

    /**
     * @var
     */
    private $status;

    /**
     * @param FormFlowInterface $flow
     */
    public function __construct(FormFlowInterface $flow, SkuskuPayment $payment, $status)
    {
        parent::__construct($flow);
        $this->payment = $payment;
        $this->status = $status;
    }

    /**
     * @return SkuskuPayment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
