<?php

namespace GGGGino\SkuskuCartBundle\Model;

/**
 * Interface SkuskuSupplierInterface
 * @package GGGGino\SkuskuCartBundle\Model
 * @deprecated this isn't needed maybe
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