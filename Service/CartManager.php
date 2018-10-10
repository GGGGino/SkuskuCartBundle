<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuProductInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
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

    /** @var  boolean */
    private $handled = false;

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

    /**
     *  Empty the cart tables
     */
    public function clearCart()
    {
        $this->em->createQuery('DELETE GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct cp')->execute();
        $this->em->createQuery('DELETE GGGGino\SkuskuCartBundle\Model\SkuskuCart c')->execute();
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     */
    public function addProductToCart(Request $request, FormInterface $form)
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

            /** @var SkuskuCart $cart */
            $cart = $this->getCartFromCustomer($customer);

            if( !$cart ){
                $cart = new SkuskuCart();
                $cart->setDateAdd(new \DateTime());
                $cart->setCustomer($customer);
                $this->em->persist($cart);
            }

            $cart->setDateUpd(new \DateTime());

            /** @var SkuskuCartProduct $productCart */
            if( $productCart = $cart->getProduct($productReference)->first() ){
                $productCart->setQuantity($productCart->getQuantity() + $quantity);
            }else{
                $productCart = new SkuskuCartProduct();
                $productCart->setProduct($productReference);
                $productCart->setQuantity($quantity);

                $cart->addProduct($productCart);
                $this->em->persist($productCart);
            }

            $this->em->flush();
        }
    }
}