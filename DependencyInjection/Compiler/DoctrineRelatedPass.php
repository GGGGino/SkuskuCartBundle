<?php

namespace GGGGino\SkuskuCartBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class DoctrineRelatedPass
 * @package GGGGino\SkuskuCartBundle\DependencyInjection\Compiler
 * @deprecated Not used
 */
class DoctrineRelatedPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('doctrine.orm.listeners.resolve_target_entity')) {
            return;
        }
    }
}