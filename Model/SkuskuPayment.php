<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Payment;

/**
 * @ORM\Table(name="skusku_payment")
 * @ORM\Entity
 */
class SkuskuPayment extends Payment
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;
}