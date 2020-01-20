<?php

namespace GGGGino\SkuskuCartBundle\Form;

use Craue\FormFlowBundle\Form\FormFlowInterface;
use GGGGino\SkuskuCartBundle\Entity\CartForm;
use GGGGino\SkuskuCartBundle\Event\PostPaymentCartEvent;
use GGGGino\SkuskuCartBundle\Event\PostSubmitCartEvent;
use GGGGino\SkuskuCartBundle\Event\PrePersistOrderEvent;
use GGGGino\SkuskuCartBundle\Event\PreSubmitCartEvent;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuPayment;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use GGGGino\SkuskuCartBundle\Service\OrderManager;
use Payum\Core\GatewayInterface;
use Payum\Core\Payum;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CartFlow extends CartFlowBase
{
    const PRE_SUBMIT = 'skusku_cart.pre_submit';

    const POST_SUBMIT = 'skusku_cart.post_submit';

    const POST_PAYMENT = 'skusku_cart.post_payment';

    const PRE_PERSIST_ORDER = 'skusku_cart.pre_persist_order';

    const TRANSITION_RESET_CART = 'emptycart';

    /**
     * @var CartManager
     */
    protected $cartManager;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Payum
     */
    protected $payum;

    /**
     * @var OrderManager
     */
    protected $orderManager;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * @var bool
     */
    protected $allowAnonymous;

    /**
     * @var string
     */
    protected $cartMode;    

    /**
     * CartFlowBase constructor.
     * @param array $configSteps
     * @param CartManager $cartManager
     * @param OrderManager $orderManager
     * @param RequestStack $requestStack
     */
    public function __construct(
        array $configSteps,
        CartManager $cartManager,
        OrderManager $orderManager,
        RequestStack $requestStack)
    {
        parent::__construct($configSteps);

        $this->cartManager = $cartManager;
        $this->requestStack = $requestStack;
        $this->orderManager = $orderManager;
    }

    /**
     * @inheritdoc
     */
    protected function loadStepsConfig()
    {
        $this->configSteps['payment']['skip'] = function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
            /** @var CartForm $data */
            $data = $flow->getFormData();

            $paymentMethod = $data->getPaymentMethod();

            // se non è settato vuol dire che non ci sono ancora arrivato
            if( !$paymentMethod )
                return false;

            /** @var GatewayInterface $gateway */
            $gateway = $this->payum->getGateway($paymentMethod);

            return true;
        };

        return $this->configSteps;
    }

    /**
     * @param $form
     * @param CartForm $formData
     * @return Response|null
     *
     * @throws \Payum\Core\Reply\ReplyInterface
     * @throws null
     */
    public function handleSubmit(&$form, $formData)
    {
        if ($this->isValid($form)) {
            $this->saveCurrentStepData($form);


            if( !$this->allowAnonymous )
                throw new AccessDeniedException("Anonymous users cannot buy");

            // @todo done this because craue form flow doesn't permit to add a custom action
            if( $this->requestStack->getCurrentRequest()->request->get('flow_cart_transition') == self::TRANSITION_RESET_CART ) {
                $this->emptyCart($formData);
                $this->reset();
                $form = $this->createForm();
                return null;
            }


            if ($this->nextStep() && $this->cartMode != 'single_page') {
                // form for the next step
                $form = $this->createForm();
            } else {
                // flow finished
                /** @var SkuskuCart $finalCart */
                $finalCart = $formData->getCart();                

                if ($this->hasListeners(self::PRE_SUBMIT)) {
                    $event = new PreSubmitCartEvent($this, $finalCart);
                    $this->eventDispatcher->dispatch(self::PRE_SUBMIT, $event);
                }

                $this->cartManager->persistCart($finalCart);

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
                    $formData->getPaymentMethod(),
                    $payment,
                    'done' // the route to redirect after capture
                );

                $finalCart->setPayment($payment);

                $requestFields = $this->requestStack->getCurrentRequest()->request->get('choosePayment');
                if(isset($requestFields['additionalFields']) && count($requestFields['additionalFields']) > 0 ) {
                    $finalCart->setAdditionalFields(json_encode($requestFields['additionalFields']));
                }                

                $this->cartManager->flushCart($finalCart);

                $this->reset(); // remove step data from the session

                if ($this->hasListeners(self::POST_SUBMIT)) {
                    $event = new PostSubmitCartEvent($this, $finalCart);
                    $this->eventDispatcher->dispatch(self::POST_SUBMIT, $event);
                }

                return new RedirectResponse($captureToken->getTargetUrl());
            }
        }
    }

    /**
     * Excecute all the listener tagged with "skusku_cart.post_payment"
     * Save the cart as order
     *
     * @param $payment
     * @return FormInterface
     */
    public function handleDone(SkuskuPayment $payment, $status)
    {
        if ($this->hasListeners(self::POST_PAYMENT)) {
            $event = new PostPaymentCartEvent($this, $payment, $status);
            $this->eventDispatcher->dispatch(self::POST_PAYMENT, $event);
        }

        $order = $this->orderManager->buildOrderFromCart($payment->getCart());

        if ($this->hasListeners(self::PRE_PERSIST_ORDER)) {
            $event = new PrePersistOrderEvent($this, $order);
            $this->eventDispatcher->dispatch(self::PRE_PERSIST_ORDER, $event);
        }

        $this->orderManager->saveOrder($order);

        // you have order and payment status
        // so you can do whatever you want for example you can just print status and payment details.
    }

    protected function emptyCart(CartForm $formData)
    {
        $this->cartManager->emptyCart($formData);
        $this->cartManager->persistCart($formData->getCart());
        $this->cartManager->flushCart($formData->getCart());
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

    /**
     * @param TokenStorage $tokenStorage
     * @return CartFlow
     */
    public function setTokenStorage($tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        return $this;
    }

    /**
     * @param boolean $allowAnonymous
     * @return CartFlow
     */
    public function setAllowAnonymous($allowAnonymous)
    {
        $this->allowAnonymous = $allowAnonymous;
        return $this;
    }

    /**
     * @param boolean $cartMode
     * @return CartFlow
     */
    public function setCartMode($cartMode)
    {
        $this->cartMode = $cartMode;
        return $this;
    }    
}