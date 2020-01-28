<?php

namespace GGGGino\SkuskuCartBundle\Controller;

use GGGGino\SkuskuCartBundle\Entity\CartForm;
use GGGGino\SkuskuCartBundle\Form\CartFlow;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use GGGGino\SkuskuCartBundle\Event\TokenNotFoundCartEvent;
use Payum\Core\Gateway;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GGGGino\SkuskuCartBundle\Model\SkuskuPayment;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\Capture;

/**
 * Class CartController
 * @package GGGGino\SkuskuCartBundle\Controller
 */
class CartController extends Controller
{
    /**
     * Cart page
     *
     * @Route("/cart", name="cart_page")
     */
    public function cartAction()
    {

        $cartMode = $this->getParameter('ggggino_skuskucart.cart_mode');

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

        $response = $flow->handleSubmit($form, $formData);

        if ( $response instanceof RedirectResponse ) {
            return $response;
        }

        return $this->render($cartTemplate, array(
            'form' => $form->createView(),
            'flow' => $flow,
            'additional_fields' => $this->getParameter('ggggino_skuskucart.additional_fields'),
            'cart_mode' => $this->getParameter('ggggino_skuskucart.cart_mode')
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
     * @Route("/done", name="done")
     */
    public function doneAction(Request $request)
    {
        /** @var string $cartFlowClass */
        $cartFlowClass = $this->getParameter('ggggino_skuskucart.stepform_class');

        /** @var CartFlow $flow */
        $flow = $this->get($cartFlowClass);

        try {
            $token = $this->get('payum')->getHttpRequestVerifier()->verify($request);
        } catch (\Exception $tokenNotFound) {
            // To remove this if because everithing is managed in the event listener
            if(null !== $this->getParameter('ggggino_skuskucart.redirect_after_done_route')) {
                return $this->redirectToRoute($redirectRoute);
            }

            $event = new TokenNotFoundCartEvent();
            return $this->container->get('event_dispatcher')->dispatch($flow::TOKEN_NOT_FOUND, $event)->getResponse();

        }        

        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        $this->get('payum')->getHttpRequestVerifier()->invalidate($token);

        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();

        $flow->handleDone($payment, $status);

        if ( $this->container->hasParameter('ggggino_skuskucart.templates.done_layout') ) {
            return $this->render($this->container->getParameter('ggggino_skuskucart.templates.done_layout'), array(
                'status' => $status,
                'payment' => $payment
            ));
        }

        return new JsonResponse(array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            )
        ));
    }
}
