<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkuskuCartProductBase
 * @ORM\MappedSuperclass()
 */
abstract class SkuskuCartProductBase
{
    /**
     * @ORM\ManyToOne(targetEntity="SkuskuCart", inversedBy="products")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    protected $cart;

    /**
     * @ORM\ManyToOne(targetEntity="SkuskuProductInterface")
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
}
