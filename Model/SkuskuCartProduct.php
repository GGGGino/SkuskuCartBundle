<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SkuskuCartProduct
 *
 * @ORM\Table(name="skusku_cart_product")
 * @ORM\Entity()
 */
class SkuskuCartProduct extends SkuskuCartProductBase
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
