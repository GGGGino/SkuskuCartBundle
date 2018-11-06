<?php

namespace GGGGino\SkuskuCartBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use GGGGino\SkuskuCartBundle\Event\PostPaymentCartEvent;
use GGGGino\SkuskuCartBundle\Event\PostSubmitCartEvent;
use GGGGino\SkuskuCartBundle\Event\PreSubmitCartEvent;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuPayment;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use Payum\Core\Gateway;
use Payum\Core\Payum;
use Payum\Core\Request\Capture;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class CartFlow extends CartFlowBase
{
    const PRE_SUBMIT = 'skusku_cart.pre_submit';

    const POST_SUBMIT = 'skusku_cart.post_submit';

    const POST_PAYMENT = 'skusku_cart.post_payment';

    /**
     * @var CartManager
     */
    private $cartManager;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Payum
     */
    private $payum;

    /**
     * CartFlowBase constructor.
     * @param array $configSteps
     * @param CartManager $cartManager
     * @param RequestStack $requestStack
     */
    public function __construct(array $configSteps, CartManager $cartManager, RequestStack $requestStack)
    {
        parent::__construct($configSteps);

        $this->cartManager = $cartManager;
        $this->requestStack = $requestStack;
    }

    /**
     * @param $form
     * @param $formData
     * @return Response|void
     *
     * @throws \Payum\Core\Reply\ReplyInterface
     * @throws null
     */
    public function handleSubmit(&$form, $formData)
    {
        if ($this->isValid($form)) {
            $this->saveCurrentStepData($form);

            if ($this->nextStep()) {
                // form for the next step
                $form = $this->createForm();
            } else {
                // flow finished
                /** @var SkuskuCart $finalCart */
                $finalCart = $formData->getCart();

                if ($this->hasListeners(self::PRE_SUBMIT)) {
                    $event = new PreSubmitCartEvent($this, $formData);
                    $this->eventDispatcher->dispatch(self::PRE_SUBMIT, $event);
                }

                $this->cartManager->saveCart($finalCart);

                $storage = $this->payum->getStorage('GGGGino\SkuskuCartBundle\Model\SkuskuPayment');

                $payment = new SkuskuPayment();
                $payment->setNumber(uniqid());
                $payment->setCurrencyCode($finalCart->getCurrency()->getIsoCode());
                $payment->setTotalAmount($finalCart->getTotalPrice()); // 1.23 EUR
                $payment->setDescription($finalCart->getTotalQuantity());
                $payment->setClientId($finalCart->getCustomer());
                $payment->setClientEmail($finalCart->getCustomer()->getEmail());

                $storage->update($payment);

                $captureToken = $this->payum->getTokenFactory()->createCaptureToken(
                    'paypal_express_checkout_and_doctrine_orm',
                    $payment,
                    'done' // the route to redirect after capture
                );

                $finalCart->setPayment($payment);

                $this->cartManager->flushCart($finalCart);

                $this->reset(); // remove step data from the session

                if ($this->hasListeners(self::POST_SUBMIT)) {
                    $event = new PostSubmitCartEvent($this, $formData);
                    $this->eventDispatcher->dispatch(self::POST_SUBMIT, $event);
                }

                return new RedirectResponse($captureToken->getTargetUrl());

                /** @var Gateway $gateway */
                $gateway = $this->payum->getGateway('paypal_express_checkout_and_doctrine_orm');
                $gateway->execute(new Capture($payment));

                // commento il flush perchè sembra che lo faccia già in $gateway->execute
                // $em->flush();

                $this->reset(); // remove step data from the session

                /** @var Session $session */
                $session = $this->requestStack->getCurrentRequest()->getSession();

                $session->getFlashBag()->add('success', 'order_done');
            }
        }
    }

    /**
     * @param $payment
     * @return FormInterface
     */
    public function handleDone(SkuskuPayment $payment, $status)
    {
        // @todo create a custom event dispatcher
        if ($this->hasListeners(self::POST_PAYMENT)) {
            $event = new PostPaymentCartEvent($this, $payment, $status);
            $this->eventDispatcher->dispatch(self::POST_PAYMENT, $event);
        }

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

    /**
     * @param mixed $payum
     * @return CartFlow
     */
    public function setPayum($payum)
    {
        $this->payum = $payum;
        return $this;
    }
}