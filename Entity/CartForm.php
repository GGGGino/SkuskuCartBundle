<?php

namespace GGGGino\SkuskuCartBundle\Entity;


use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entità usata per la gestione del form multistep
 *
 * Class CartForm
 * @package GGGGino\SkuskuCartBundle\Entity
 */
class CartForm
{
    /**
     * @var SkuskuCart
     */
    private $cart;

    /**
     * @var string
     */
    private $paymentMethod;

    /**
     * CartForm constructor.
     * @param SkuskuCart $cart
     */
    public function __construct(SkuskuCart $cart)
    {
        $this->cart = $cart;
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
     * @return \string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param \string $paymentMethod
     * @return CartForm
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
}