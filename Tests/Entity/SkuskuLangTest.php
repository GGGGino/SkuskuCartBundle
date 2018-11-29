<?php

namespace GGGGino\SkuskuCartBundle\Tests\Entity;

use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;

class SkuskuLangTest implements SkuskuLangInterface
{
    private $name = "Lang";
    private $active = true;
    private $isoCode = "ISOCODE";
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * @param mixed $name
     * @return SkuskuLangTest
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $active
     * @return SkuskuLangTest
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @param mixed $isoCode
     * @return SkuskuLangTest
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;
        return $this;
    }
}