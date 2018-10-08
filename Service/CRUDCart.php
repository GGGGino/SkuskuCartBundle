<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;

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