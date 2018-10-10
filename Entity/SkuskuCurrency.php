<?php

namespace GGGGino\SkuskuCartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyBase;

/**
 * SkuskuCurrency
 *
 * @ORM\Table(name="skusku_currency")
 * @ORM\Entity()
 */
class SkuskuCurrency extends SkuskuCurrencyBase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
