<?php

namespace GGGGino\SkuskuCartBundle\Controller;

use GGGGino\SkuskuCartBundle\Entity\CartForm;
use GGGGino\SkuskuCartBundle\Form\CartFlow;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProduct;
use GGGGino\SkuskuCartBundle\Model\SkuskuCartProductInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
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

        $response = $flow->handleSubmit($form, $formData);

        if( $response instanceof RedirectResponse ){
            return $response;
        }

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
     * @Route("/done", name="done")
     */
    public function doneAction(Request $request)
    {
        $token = $this->get('payum')->getHttpRequestVerifier()->verify($request);

        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        // you can invalidate the token. The url could not be requested any more.
        // $this->get('payum')->getHttpRequestVerifier()->invalidate($token);

        // Once you have token you can get the model from the storage directly.
        //$identity = $token->getDetails();
        //$payment = $this->get('payum')->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();

        // you have order and payment status
        // so you can do whatever you want for example you can just print status and payment details.

        return new JsonResponse(array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ),
        ));
    }
}
