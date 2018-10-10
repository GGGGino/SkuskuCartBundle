<?php

namespace GGGGino\SkuskuCartBundle\Service;

/**
 * Interface CurrencyManagerInterface
 * @package GGGGino\SkuskuCartBundle\Service
 */
interface CurrencyManagerInterface
{
    /**
     * Get all the available currencies
     *
     * @return mixed
     */
    public function getActiveCurrencies();

    /**
     * Get the current currency
     *
     * @return mixed
     */
    public function getCurrentCurrency();
}