<?php

namespace GGGGino\SkuskuCartBundle\Event;

use Craue\FormFlowBundle\Event\FormFlowEvent;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;

/**
 *  Event used *before* the procedure save the cart on the db
 *
 * Class PostSubmitCartEvent
 * @package GGGGino\SkuskuCartBundle\Event
 */
class PreSubmitCartEvent extends FormFlowEvent
{
    /**
     * @var SkuskuCart
     */
    private $cart;

    /**
     * @param FormFlowInterface $flow
     */
    public function __construct(FormFlowInterface $flow, SkuskuCart $cart)
    {
        parent::__construct($flow);
        $this->cart = $cart;
    }

    /**
     * @return SkuskuCart
     */
    public function getCart()
    {
        return $this->cart;
    }
}
