<?php

namespace GGGGino\SkuskuCartBundle\Model;

/**
 * Interface SkuskuProductInterface
 * @package GGGGino\SkuskuCartBundle\Model
 */
interface SkuskuProductInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return SkuskuSupplierInterface
     */
    public function getSupplier();

    /**
     * @return mixed
     */
    public function getPrice();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return boolean
     */
    public function getActive();
}