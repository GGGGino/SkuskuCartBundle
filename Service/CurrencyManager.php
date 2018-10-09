<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CurrencyManager
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
     * @return SkuskuCustomerInterface[]
     */
    public function getActiveCurrencies()
    {
        return $this->em->getRepository(SkuskuCurrencyInterface::class)->findAll();
    }

    /**
     * @return SkuskuCustomerInterface
     */
    public function getCurrentCurrency()
    {
        return $this->getActiveCurrencies()[0];
    }
}