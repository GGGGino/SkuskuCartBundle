<?php

namespace GGGGino\SkuskuCartBundle\EventSubscriber;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Recognize the currency from the url(if exist) and set it in the section
 *
 * Class CurrencySubscriber
 * @package Allyou\ManagementBundle\EventSubscriber
 */
class CurrencySubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $defaultCurrency;

    /**
     * @param string $defaultCurrency
     */
    public function __construct($defaultCurrency = 'EUR')
    {
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->hasPreviousSession()) {
            return;
        }

        // try to see if the currency has been set as a "cu" routing parameter
        if ($currency = $request->query->get('cu')) {
            $request->attributes->set('skusku_cu', $currency);
            $request->getSession()->set('skusku_cu', $currency);
        } else {
            // if no explicit currency has been set on this request, use one from the session
            $sessCurrency = $request->getSession()->get('skusku_cu', $this->defaultCurrency);
            $request->attributes->set('skusku_cu', $sessCurrency);
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 20)),
        );
    }
}