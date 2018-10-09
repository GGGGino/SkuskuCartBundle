<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class LangManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * CartExtension constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     */
    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return SkuskuLangInterface[]
     */
    public function getActiveLanguages()
    {
        return $this->em->getRepository(SkuskuLangInterface::class)->findAll();
    }

    /**
     * @return SkuskuLangInterface
     */
    public function getCurrentLanguage()
    {
        return $this->getActiveLanguages()[0];
    }
}