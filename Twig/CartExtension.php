<?php

namespace GGGGino\SkuskuCartBundle\Twig;

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

    private $templateFile = "GGGGinoSkuskuCartBundle:Cart:cart_preview.html.twig";

    /**
     * CartExtension constructor.
     * @param Environment $templating
     * @param EntityManager $em
     */
    public function __construct(Environment $templating, EntityManager $em)
    {
        $this->templating = $templating;
        $this->em = $em;
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

        return $this->templating->render($template, array());
    }
}