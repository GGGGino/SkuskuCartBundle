<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class CRUDCart
 * @package GGGGino\SkuskuCartBundle\Service
 * @deprecated Use CartManager instead
 */
class CRUDCart
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * CartExtension constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function updateOrCreateCartFromRawParams($postParams)
    {
        if( isset($postParams['idProduct']) ){
            
        }
    }
}