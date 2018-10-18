<?php

namespace GGGGino\SkuskuCartBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * @ORM\Table(name="skusku_payment_token")
 * @ORM\Entity
 */
class SkuskuPaymentToken extends Token
{
}