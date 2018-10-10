<?php

namespace GGGGino\SkuskuCartBundle\Service;

/**
 * Interface LangManagerInterface
 * @package GGGGino\SkuskuCartBundle\Service
 */
interface LangManagerInterface
{
    /**
     * Get all the available currencies
     *
     * @return mixed
     */
    public function getActiveLanguages();

    /**
     * Get the current currency
     *
     * @return mixed
     */
    public function getCurrentLanguage();
}