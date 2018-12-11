<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkuskuCartProductBase
 * @ORM\MappedSuperclass()
 */
abstract class SkuskuCartProductBase implements SkuskuCartProductInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="SkuskuCart", inversedBy="products")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     * @var SkuskuCart
     */
    protected $cart;

    /**
     * @ORM\ManyToOne(targetEntity="SkuskuProductInterface", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @var SkuskuProductInterface
     */
    protected $product;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    public function __toString()
    {
        return "SkuskuCartProductBase";
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     * @return SkuskuCartProductBase
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return SkuskuCartProductBase
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     * @return SkuskuCartProductBase
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * Get the amount of price of the product in the cart
     *
     * @return float
     */
    public function getSubtotal()
    {
        return $this->getProductPrice() * $this->quantity;
    }

    /**
     * Get the amount of price of the single product
     *
     * @return float
     */
    public function getProductPrice()
    {
        return $this->getProduct()->getPrice();
    }

    public function getProductAttribute(){}
}
