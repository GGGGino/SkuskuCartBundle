<?php

namespace GGGGino\SkuskuCartBundle\Entity;


use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use Doctrine\Common\Collections\ArrayCollection;

class CartForm
{
    /**
     * @var SkuskuCart
     */
    private $cart;

    /**
     * @var string[]
     */
    private $paymentsMethod;

    /**
     * CartForm constructor.
     * @param SkuskuCart $cart
     */
    public function __construct(SkuskuCart $cart)
    {
        $this->cart = $cart;
        $this->paymentsMethod = array(

        );
    }

    /**
     * @return SkuskuCart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param SkuskuCart $cart
     * @return CartForm
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @return SkuskuCartProductInterface[]|ArrayCollection
     */
    public function getCartProducts()
    {
        return $this->cart->getProducts();
    }

    /**
     * @return float
     */
    public function getTotalQuantity()
    {
        return $this->cart->getTotalQuantity();
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->cart->getTotalPrice();
    }

    /**
     * @return \string[]
     */
    public function getPaymentsMethod()
    {
        return $this->paymentsMethod;
    }

    /**
     * @param \string[] $paymentsMethod
     * @return CartForm
     */
    public function setPaymentsMethod($paymentsMethod)
    {
        $this->paymentsMethod = $paymentsMethod;
        return $this;
    }
}