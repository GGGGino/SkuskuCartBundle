<?php

namespace GGGGino\SkuskuCartBundle\Model;

/**
 * Interface SkuskuCurrencyInterface
 * @package GGGGino\SkuskuCartBundle\Model
 */
interface SkuskuCurrencyInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIsoCode();

    /**
     * @return string
     */
    public function getSign();
}