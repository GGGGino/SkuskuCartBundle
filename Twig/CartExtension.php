<?php

namespace GGGGino\SkuskuCartBundle\Twig;

use GGGGino\SkuskuCartBundle\Model\SkuskuCustomerInterface;
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
     * @var EntityManager
     */
    private $em;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    private $templateFile = "GGGGinoSkuskuCartBundle:Cart:cart_preview.html.twig";

    /**
     * CartExtension constructor.
     * @param Environment $templating
     * @param EntityManager $em
     */
    public function __construct(Environment $templating, EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->templating = $templating;
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('render_preview_cart', array($this, 'renderPreviewCart'), array(
                'is_safe' => array('html')
            )),
        );
    }

    public function renderPreviewCart($template = null)
    {
        if( !$template )
            $template = $this->templateFile;

        /** @var SkuskuCustomerInterface $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $cart = $this->em->getRepository('GGGGino\SkuskuCartBundle\Model\SkuskuCart')->findOneByCustomer($user);

        return $this->templating->render($template, array(
            'cart' => $cart,
        ));
    }
}