<?php

namespace GGGGino\SkuskuCartBundle\Twig;

use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use GGGGino\SkuskuCartBundle\Service\CurrencyManager;
use GGGGino\SkuskuCartBundle\Service\LangManager;
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

    /**
     * @var CurrencyManager
     */
    private $currencyManager;

    /**
     * @var LangManager
     */
    private $langManager;

    /**
     * @var string
     */
    private $templatePreviewCart = "GGGGinoSkuskuCartBundle:Cart:cart_preview.html.twig";

    /**
     * @var string
     */
    private $templateCurrencyCart = "GGGGinoSkuskuCartBundle:Cart:cart_currency_preview.html.twig";

    /**
     * @var string
     */
    private $templateLangCart = "GGGGinoSkuskuCartBundle:Cart:cart_lang_preview.html.twig";

    /**
     * CartExtension constructor.
     * @param Environment $templating
     * @param CartManager $cartManager
     * @param CurrencyManager $currencyManager
     * @param LangManager $langManager
     */
    public function __construct(
        Environment $templating,
        CartManager $cartManager,
        CurrencyManager $currencyManager,
        LangManager $langManager )
    {
        $this->templating = $templating;
        $this->cartManager = $cartManager;
        $this->currencyManager = $currencyManager;
        $this->langManager = $langManager;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('render_preview_cart', array($this, 'renderPreviewCart'), array(
                'is_safe' => array('html')
            )),
            new TwigFunction('render_currency_cart', array($this, 'renderCurrencyCart'), array(
                'is_safe' => array('html')
            )),
            new TwigFunction('render_lang_cart', array($this, 'renderLangCart'), array(
                'is_safe' => array('html')
            ))
        );
    }

    /**
     * Render the cart preview, with a little summary
     *
     * @param null $template
     * @return string
     */
    public function renderPreviewCart($template = null)
    {
        if( !$template )
            $template = $this->templatePreviewCart;

        /** @var SkuskuCart $cart */
        $cart = $this->cartManager->getCartFromCustomer();

        return $this->templating->render($template, array(
            'cart' => $cart,
        ));
    }

    /**
     * Render the currency list
     *
     * @param string $template
     * @return string
     */
    public function renderCurrencyCart($template = null)
    {
        if( !$template )
            $template = $this->templateCurrencyCart;

        /** @var SkuskuCurrencyInterface[] $currencies */
        $currencies = $this->currencyManager->getActiveCurrencies();
        /** @var SkuskuCurrencyInterface $currentCurrency */
        $currentCurrency = $this->currencyManager->getCurrentCurrency();

        return $this->templating->render($template, array(
            'currencies' => $currencies,
            'currentCurrency' => $currentCurrency
        ));
    }

    /**
     * @param null $template
     * @return string
     */
    public function renderLangCart($template = null)
    {
        if( !$template )
            $template = $this->templateLangCart;

        /** @var SkuskuLangInterface[] $languages */
        $languages = $this->langManager->getActiveLanguages();

        /** @var SkuskuLangInterface $currentLanguage */
        $currentLanguage = $this->langManager->getCurrentLanguage();

        return $this->templating->render($template, array(
            'languages' => $languages,
            'currentLanguage' => $currentLanguage
        ));
    }
}