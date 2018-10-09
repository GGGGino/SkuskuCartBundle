<?php

namespace GGGGino\SkuskuCartBundle\Model;

/**
 * Interface SkuskuLangInterface
 * @package GGGGino\SkuskuCartBundle\Model
 */
interface SkuskuLangInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return bool
     */
    public function getActive();

    /**
     * @return string
     */
    public function getIsoCode();
}