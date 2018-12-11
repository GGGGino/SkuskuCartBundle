<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuOrder;
use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class OrderManager
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
     * @var bool
     */
    private $allowAnonymous;

    /**
     * CartExtension constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     * @param bool $allowAnonymous
     */
    public function __construct(EntityManager $em, TokenStorage $tokenStorage, $allowAnonymous = true)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->allowAnonymous = $allowAnonymous;
    }

    /**
     * Create a temp Entity with some field initialized
     *
     * @return SkuskuOrder
     */
    private function createTempOrder()
    {
        $order = new SkuskuOrder();
        $order->setDateAdd(new \DateTime());
        $order->setDateUpd(new \DateTime());

        return $order;
    }

    /**
     * Build the order from a cart
     *
     * @param SkuskuCart $cart
     * @return SkuskuOrder
     */
    public function buildOrderFromCart(SkuskuCart $cart)
    {
        /** @var SkuskuOrder $order */
        $order = $this->createTempOrder();

        $order->setCart($cart);
        $order->setTotalPaid($cart->getTotalPrice());
        $order->setTotalPaidReal($cart->getTotalPrice());
        $order->setTotalProducts($cart->getTotalQuantity());
        $order->setCustomer($cart->getCustomer());
        $order->setCurrency($cart->getCurrency());
        $order->setLang($cart->getLang());

        $this->setCartOrdered($cart);

        return $order;
    }

    /**
     * @param SkuskuOrder $order
     */
    public function saveOrder(SkuskuOrder $order)
    {
        $this->em->persist($order);
        $this->em->flush();
    }

    public function setCartOrdered(SkuskuCart $cart)
    {
        $cart->setStatus(SkuskuCart::STATUS_ORDERED);
    }
}