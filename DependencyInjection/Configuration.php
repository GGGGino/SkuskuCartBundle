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

        $rootNode
            ->children()
                ->booleanNode('allow_anonymous_shop')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
