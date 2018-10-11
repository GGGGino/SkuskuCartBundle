<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkuskuCurrency
 * @ORM\MappedSuperclass()
 */
abstract class SkuskuCurrencyBase
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="iso_code", type="string", length=3)
     */
    protected $isoCode;

    /**
     * @var string
     *
     * @ORM\Column(name="sign", type="string", length=8)
     */
    protected $sign;

    /**
     * @var int
     *
     * @ORM\Column(name="blank", type="smallint", options={"default" : 0})
     */
    protected $blank = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="format", type="smallint", options={"default" : 0})
     */
    protected $format = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="decimals", type="smallint", options={"default" : 0})
     */
    protected $decimals = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="conversion_rate", type="decimal", precision=13, scale=6, options={"default" : 0})
     */
    protected $conversionRate = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean", options={"default" : 0})
     */
    protected $deleted = 0;

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return SkuskuCurrencyBase
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isoCode.
     *
     * @param string $isoCode
     *
     * @return SkuskuCurrencyBase
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * Get isoCode.
     *
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * Set sign.
     *
     * @param string $sign
     *
     * @return SkuskuCurrencyBase
     */
    public function setSign($sign)
    {
        $this->sign = $sign;

        return $this;
    }

    /**
     * Get sign.
     *
     * @return string
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * Set blank.
     *
     * @param int $blank
     *
     * @return SkuskuCurrencyBase
     */
    public function setBlank($blank)
    {
        $this->blank = $blank;

        return $this;
    }

    /**
     * Get blank.
     *
     * @return int
     */
    public function getBlank()
    {
        return $this->blank;
    }

    /**
     * Set format.
     *
     * @param int $format
     *
     * @return SkuskuCurrencyBase
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format.
     *
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set decimals.
     *
     * @param int $decimals
     *
     * @return SkuskuCurrencyBase
     */
    public function setDecimals($decimals)
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Get decimals.
     *
     * @return int
     */
    public function getDecimals()
    {
        return $this->decimals;
    }

    /**
     * Set conversionRate.
     *
     * @param string $conversionRate
     *
     * @return SkuskuCurrencyBase
     */
    public function setConversionRate($conversionRate)
    {
        $this->conversionRate = $conversionRate;

        return $this;
    }

    /**
     * Get conversionRate.
     *
     * @return string
     */
    public function getConversionRate()
    {
        return $this->conversionRate;
    }

    /**
     * Set deleted.
     *
     * @param bool $deleted
     *
     * @return SkuskuCurrencyBase
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return bool
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
