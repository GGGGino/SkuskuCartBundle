<?php

namespace GGGGino\SkuskuCartBundle\Twig;

use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Doctrine\ORM\EntityManager;

class CartExtension extends AbstractExtension
{
    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var CartManager
     */
    private $cartManager;

    private $templateFile = "GGGGinoSkuskuCartBundle:Cart:cart_preview.html.twig";

    /**
     * CartExtension constructor.
     * @param Environment $templating
     * @param CartManager $cartManager
     */
    public function __construct(Environment $templating, CartManager $cartManager)
    {
        $this->templating = $templating;
        $this->cartManager = $cartManager;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('render_preview_cart', array($this, 'renderPreviewCart'), array(
                'is_safe' => array('html')
            )),
            new TwigFunction('render_currency_cart', array($this, 'renderCurrencyCart'), array(
                'is_safe' => array('html')
            )),
        );
    }

    /**
     * @param null $template
     * @return string
     */
    public function renderPreviewCart($template = null)
    {
        if( !$template )
            $template = $this->templateFile;

        /** @var SkuskuCart $cart */
        $cart = $this->cartManager->getCartFromCustomer();

        return $this->templating->render($template, array(
            'cart' => $cart,
        ));
    }

    public function renderCurrencyCart($template = null)
    {
        if( !$template )
            $template = $this->templateFile;

        /** @var SkuskuCart $cart */
        $cart = $this->cartManager->getCartFromCustomer();

        return $this->templating->render($template, array(
            'cart' => $cart,
        ));
    }
}