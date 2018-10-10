<?php

namespace GGGGino\SkuskuCartBundle\Entity;

use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_userr")
 */
class SkuskuUser extends BaseUser implements SkuskuCustomerInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return true;
    }
}
