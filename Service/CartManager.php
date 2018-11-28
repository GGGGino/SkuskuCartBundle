<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuOrder;
use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

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

    /** @var  boolean */
    private $handled = false;

    /**
     * @var bool
     */
    private $allowAnonymous;

    /**
     * @var CurrencyManager
     */
    private $currencyManager;

    /**
     * @var LangManager
     */
    private $langManager;

    /**
     * CartExtension constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     */
    public function __construct(EntityManager $em, TokenStorage $tokenStorage, $allowAnonymous = true)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->allowAnonymous = $allowAnonymous;
    }

    /**
     * Get the cart from a given Customer.
     * If the customer is not passed, is taken from the session
     *
     * @api
     *
     * @param SkuskuCustomerInterface|null $customer
     * @return SkuskuCart|null
     */
    public function getCartFromCustomer(SkuskuCustomerInterface $customer = null)
    {
        if( !$customer ) {
            /** @var SkuskuCustomerInterface $user */
            $customer = $this->tokenStorage->getToken()->getUser();
        }

        if( !($customer instanceof UserInterface) )
            $customer = null;

        if( !$this->allowAnonymous && !$customer )
            throw new AccessDeniedException("Anonymous users cannot buy");

        return $this->em->getRepository('GGGGino\SkuskuCartBundle\Model\SkuskuCart')->findOneByCustomer($customer);
    }

    /**
     * Aggiungo il carrello alla coda delle entita da processare di doctrine
     *
     * @api
     *
     * @param SkuskuCart $cart
     */
    public function persistCart(SkuskuCart $cart)
    {
        $this->em->persist($cart);
    }

    /**
     * Faccio il flush del carrello
     *
     * @api
     *
     * @param SkuskuCart $cart
     */
    public function flushCart(SkuskuCart $cart)
    {
        $this->em->flush($cart);
    }

    /**
     * Empty the cart tables for development, garbage collector purposes
     *
     * @api
     */
    public function clearCart()
    {
        $this->em->createQuery('DELETE GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct cp')->execute();
        $this->em->createQuery('DELETE GGGGino\SkuskuCartBundle\Model\SkuskuCart c')->execute();
        $this->em->createQuery('DELETE GGGGino\SkuskuCartBundle\Model\SkuskuPayment c')->execute();
        $this->em->createQuery('DELETE GGGGino\SkuskuCartBundle\Model\SkuskuPaymentToken c')->execute();
        $this->em->createQuery('DELETE GGGGino\SkuskuCartBundle\Model\SkuskuOrder c')->execute();
    }

    /**
     * Used from the mini form
     *
     * @param Request $request
     * @param FormInterface $form
     */
    public function addProductToCartForm(Request $request, FormInterface $form)
    {
        if( $this->handled )
            return;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handled = true;
            /** @var integer $idProduct */
            $idProduct = intval($form->get('idProduct')->getData());
            /** @var integer $quantity */
            $quantity = intval($form->get('quantity')->getData());
            /** @var SkuskuCustomerInterface $customer */
            $customer = $this->tokenStorage->getToken()->getUser();
            /** @var SkuskuProductInterface $productReference */
            $productReference = $this->em->getReference(SkuskuProductInterface::class, $idProduct);

            if( !($customer instanceof UserInterface) )
                $customer = null;

            if( !$this->allowAnonymous && !$customer )
                throw new AccessDeniedException("Anonymous users cannot buy");

            $this->addProductToCart($productReference, $quantity);
        }
    }

    /**
     * Add the product to the cart checking that:
     * - the cart exist
     * -- if it not exist, I create it
     * - Update the cart date
     * - add & update the cart
     *
     * @api
     *
     * @param SkuskuProductInterface $product
     * @param $quantity
     */
    public function addProductToCart(SkuskuProductInterface $product, $quantity)
    {
        /** @var SkuskuCustomerInterface $customer */
        $customer = $this->tokenStorage->getToken()->getUser();

        /** @var SkuskuCart $cart */
        $cart = $this->getCartFromCustomer($customer);

        if( !$cart ){
            $cart = $this->createNewCart($customer);
            $this->em->persist($cart);
        }

        $cart->setDateUpd(new \DateTime());

        /** @var SkuskuCartProduct $productCart */
        if( $productCart = $cart->getProduct($product)->first() ){
            $productCart->setQuantity($productCart->getQuantity() + $quantity);
        }else{
            $productCart = new SkuskuCartProduct();
            $productCart->setProduct($product);
            $productCart->setQuantity($quantity);

            $cart->addProduct($productCart);
            $this->em->persist($productCart);
        }

        $this->em->flush();
    }

    /**
     * Create new cart
     *
     * @api
     *
     * @param SkuskuCustomerInterface|null $customer
     * @return SkuskuCart
     */
    public function createNewCart(SkuskuCustomerInterface $customer = null)
    {
        $cart = new SkuskuCart();
        $cart->setDateAdd(new \DateTime());
        $cart->setCustomer($customer);
        $cart->setCurrency($this->currencyManager->getCurrentCurrency());

        return $cart;
    }

    /**
     * Build a new Order from a given cart.
     * Used for example when the payment gone good
     *
     * @api
     *
     * @param SkuskuCart $cart
     * @return SkuskuOrder
     */
    public function createNewOrderFromCart(SkuskuCart $cart)
    {
        $totPrice = $cart->getTotalPrice();

        $order = new SkuskuOrder();
        $order->setCurrency($cart->getCurrency());
        $order->setDateAdd(new \DateTime());
        $order->setCustomer($cart->getCustomer());
        $order->setCart($cart);
        $order->setLang($cart->getLang());
        $order->setTotalPaid($totPrice);
        $order->setTotalPaidReal($totPrice);
        $order->setTotalProducts($totPrice);

        return $order;
    }

    /**
     * @param CurrencyManager $currencyManager
     * @return CartManager
     */
    public function setCurrencyManager($currencyManager)
    {
        $this->currencyManager = $currencyManager;
        return $this;
    }

    /**
     * @param LangManager $langManager
     * @return CartManager
     */
    public function setLangManager($langManager)
    {
        $this->langManager = $langManager;
        return $this;
    }
}