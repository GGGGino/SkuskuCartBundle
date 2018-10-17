<?php

namespace GGGGino\SkuskuCartBundle\Entity;


use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use Doctrine\Common\Collections\ArrayCollection;

class CartForm
{
    /**
     * @var SkuskuCartProductInterface
     * @deprecated
     */
    private $cartProduct;

    /**
     * @var SkuskuCart
     */
    private $cart;

    /**
     * CartForm constructor.
     * @param SkuskuCartProductInterface $cartProduct
     */
    public function __construct(SkuskuCart $cart, SkuskuCartProductInterface $cartProduct = null)
    {
        $this->cartProduct = $cartProduct;
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
}