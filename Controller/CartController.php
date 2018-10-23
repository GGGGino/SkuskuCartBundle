<?php

namespace GGGGino\SkuskuCartBundle\Controller;

use GGGGino\SkuskuCartBundle\Entity\CartForm;
use GGGGino\SkuskuCartBundle\Form\CartFlow;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use Payum\Core\Gateway;
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

        /** @var string $cartFlowClass */
        $cartFlowClass = $this->getParameter('ggggino_skuskucart.stepform_class');

        /** @var string $cartTemplate */
        $cartTemplate = $this->getParameter('ggggino_skuskucart.templates.cart_layout');

        /** @var SkuskuCart $cart */
        $cart = $cartManager->getCartFromCustomer();

        $formData = new CartForm($cart);

        /** @var CartFlow $flow */
        $flow = $this->get($cartFlowClass); // must match the flow's service id
        $flow->bind($formData);

        // form of the current step
        $form = $flow->createForm();

        $form = $flow->handleSubmit($form, $formData);

        return $this->render($cartTemplate, array(
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
