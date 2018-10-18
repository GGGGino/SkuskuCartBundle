<?php

namespace GGGGino\SkuskuCartBundle\Controller;

use GGGGino\SkuskuCartBundle\Entity\CartForm;
use GGGGino\SkuskuCartBundle\Form\CartFlow;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GGGGino\SkuskuCartBundle\Model\SkuskuPayment;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\Capture;

class CartController extends Controller
{
    /**
     * Cart page
     *
     * @Route("/cart", name="cart_page")
     */
    public function cartAction()
    {
        /** @var CartManager $cartManager */
        $cartManager = $this->get(CartManager::class);
        /** @var SkuskuCart $cart */
        $cart = $cartManager->getCartFromCustomer();

        $formData = new CartForm($cart);

        /** @var CartFlow $flow */
        $flow = $this->get(CartFlow::class); // must match the flow's service id
        $flow->bind($formData);

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                /** @var SkuskuCart $finalCart */
                $finalCart = $formData->getCart();

                $em = $this->getDoctrine()->getManager();
                $em->persist($finalCart);

                $payment = new SkuskuPayment();
                $payment->setNumber(uniqid());
                $payment->setCurrencyCode($finalCart->getCurrency()->getIsoCode());
                $payment->setTotalAmount($finalCart->getTotalPrice()); // 1.23 EUR
                $payment->setDescription($finalCart->getTotalQuantity());
                $payment->setClientId($finalCart->getCustomer());
                $payment->setClientEmail($finalCart->getCustomer()->getEmail());

                $gateway = $this->get('payum')->getGateway('offline');
                $gateway->execute(new Capture($payment));

                $em->flush();

                $flow->reset(); // remove step data from the session

                return $this->redirect($this->generateUrl('cart_page')); // redirect when done
            }
        }

        return $this->render('GGGGinoSkuskuCartBundle::cart_page.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }

    /**
     * Cart page
     *
     * @Route("/remove_item/{product}", name="remove_item_from_cart")
     */
    public function removeItemFromCart(SkuskuCartProduct $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return new Response('ok');
    }

    /**
     * Action temporanea per i test
     *
     * @Route("/cart/clear", name="clear_cart")
     */
    public function clearAction()
    {
        /** @var CartManager $cartManager */
        $cartManager = $this->get(CartManager::class);
        $cartManager->clearCart();

        return new Response('ok');
    }

    /**
     * Action temporanea per i test
     *
     * @Route("/sample", name="sample")
     */
    public function sampleAction()
    {
        return new Response('oo');
    }
}
