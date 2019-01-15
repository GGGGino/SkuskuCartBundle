<?php

namespace GGGGino\SkuskuCartBundle\Model;

/**
 * Interface SkuskuCartProductInterface
 * @package GGGGino\SkuskuCartBundle\Model
 */
interface SkuskuCartProductInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return SkuskuCart
     */
    public function getCart();

    /**
     * @return SkuskuCartProductInterface
     */
    public function setCart($cart);

    /**
     * @return SkuskuProductInterface
     */
    public function getProduct();

    /**
     * @return mixed
     */
    public function getProductAttribute();

    /**
     * @return integer
     */
    public function getQuantity();
}