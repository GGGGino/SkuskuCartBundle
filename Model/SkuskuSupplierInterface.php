<?php

namespace GGGGino\SkuskuCartBundle\Model;

/**
 * Interface SkuskuSupplierInterface
 * @package GGGGino\SkuskuCartBundle\Model
 */
interface SkuskuSupplierInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return boolean
     */
    public function getActive();
}