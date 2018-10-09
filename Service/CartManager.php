<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CartManager
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
     * @param SkuskuCustomerInterface $customer
     * @return SkuskuCart
     */
    public function getCartFromCustomer(SkuskuCustomerInterface $customer = null)
    {
        if( !$customer ) {
            /** @var SkuskuCustomerInterface $user */
            $customer = $this->tokenStorage->getToken()->getUser();
        }

        return $this->em->getRepository('GGGGino\SkuskuCartBundle\Model\SkuskuCart')->findOneByCustomer($customer);
    }
}