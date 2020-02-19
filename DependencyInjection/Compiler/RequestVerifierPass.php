<?php

namespace GGGGino\SkuskuCartBundle\DependencyInjection\Compiler;

use GGGGino\SkuskuCartBundle\Form\CartFlow;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RequestVerifierPass
 * @package GGGGino\SkuskuCartBundle\DependencyInjection\Compiler
 */
class RequestVerifierPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has(CartFlow::class)) {
            return;
        }

        $definition = $container->findDefinition(CartFlow::class);

        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds('ggggino_skuskucart.request_verifier');

        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the TransportChain service
            $definition->addMethodCall('addRequestVerifier', [new Reference($id)]);
        }
    }
}