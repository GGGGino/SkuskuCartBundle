<?php

namespace GGGGino\SkuskuCartBundle\Model;

/**
 * Interface SkuskuCustomerInterface
 * @package GGGGino\SkuskuCartBundle\Model
 */
interface SkuskuCustomerInterface
{
    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getFirstname();

    /**
     * @return string
     */
    public function getLastname();

    /**
     * @return boolean
     */
    public function getActive();
}