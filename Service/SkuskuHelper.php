<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class SkuskuHelper
 * @package GGGGino\SkuskuCartBundle\Service
 */
class SkuskuHelper
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var array
     */
    private $abstractEntities;

    /**
     * CartExtension constructor.
     * @param EntityManager $em
     * @param array $abstractEntities
     */
    public function __construct(EntityManager $em, array $abstractEntities)
    {
        $this->em = $em;
        $this->abstractEntities = $abstractEntities;
    }

    public function getAbstractEntities()
    {
        return $this->abstractEntities;
    }

    public function getAbstractEntitiesValues()
    {
        $resultArray = array();

        foreach ($this->getAbstractEntities() as $key => $value) {
            $resultArray[] = array(
                'interface' => $key,
                'concrete' => $value
            );
        }

        return $resultArray;
    }
}