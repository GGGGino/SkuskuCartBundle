<?php

namespace GGGGino\SkuskuCartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class GGGGinoSkuskuCartExtension
 * @package Allyou\ManagementBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ggggino_skuskucart');

        /** @var array $defaultSteps gli step minimi e di default */
        $defaultSteps = array(
            'cart' => array(
                'form_type' => 'GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep1FormType',
                'label' => 'cart_resume'
            ),
            'chosePayment' => array(
                'form_type' => 'GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep2FormType',
                'label' => 'chose_payment'
            ),
            'payment' => array(
                'form_type' => 'GGGGino\SkuskuCartBundle\Form\CartFlowType\CartStep3FormType',
                'label' => 'payment'
            )
        );

        /** @var array $defaultTemplates i template minimi */
        $defaultTemplates = array(
            'cart_layout' => 'GGGGinoSkuskuCartBundle::cart_page.html.twig'
        );

        $rootNode
            ->children()
                ->booleanNode('allow_anonymous_shop')
                    ->defaultTrue()
                ->end()
                ->scalarNode('stepform_class')
                    ->defaultValue('GGGGino\SkuskuCartBundle\Form\CartFlow')
                ->end()
                ->arrayNode('stepform')
                    ->defaultValue($defaultSteps)
                    ->treatNullLike($defaultSteps)
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('form_type')->end()
                            ->scalarNode('label')->end()
                        ->end()
                    ->end()
                    ->beforeNormalization()
                        ->always(function($items) use ($defaultSteps){
                            return array_merge($defaultSteps, $items);
                        })
                    ->end()
                ->end()
                ->arrayNode('templates')
                    ->defaultValue($defaultTemplates)
                    ->treatNullLike($defaultTemplates)
                    ->scalarPrototype()->end()
                    ->beforeNormalization()
                        ->always(function($items) use ($defaultTemplates){
                            return array_merge($defaultTemplates, $items);
                        })
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
