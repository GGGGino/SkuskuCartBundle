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

    /**
     * @return SkuskuCurrencyInterface
     */
    public function setName($name);

    /**
     * @return SkuskuCurrencyInterface
     */
    public function setIsoCode($name);

    /**
     * @return SkuskuCurrencyInterface
     */
    public function setSign($name);
}