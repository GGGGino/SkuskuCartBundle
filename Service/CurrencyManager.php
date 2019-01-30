<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Exception\CurrencyNotFoundException;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CurrencyManager implements CurrencyManagerInterface
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
     * @var RequestStack
     */
    private $requestStack;

    /**
     * CartExtension constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManager $em, TokenStorage $tokenStorage, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
    }

    /**
     * @return SkuskuCurrencyInterface[]
     */
    public function getActiveCurrencies()
    {
        return $this->em->getRepository(SkuskuCurrencyInterface::class)->findAll();
    }

    /**
     * @return SkuskuCurrencyInterface
     * @throws CurrencyNotFoundException
     */
    public function getCurrentCurrency()
    {
        /** @var string $currencyIdentifier */
        $currencyIdentifier = $this->requestStack->getCurrentRequest()->attributes->get('skusku_cu');

        /** @var SkuskuCurrencyInterface $locale */
        $locale = $this->em->getRepository(SkuskuCurrencyInterface::class)->findOneByIsoCode($currencyIdentifier);

        if( !$locale ) {
            throw new CurrencyNotFoundException();
        }

        return $locale;
    }
}