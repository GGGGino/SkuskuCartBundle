<?php

namespace GGGGino\SkuskuCartBundle\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\DoctrineExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class GGGGinoSkuskuCartExtension
 * @package Allyou\ManagementBundle\DependencyInjection
 */
class GGGGinoSkuskuCartExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('ggggino_skuskucart.allow_anonymous_shop', $config['allow_anonymous_shop']);

        $container->setParameter('ggggino_skuskucart.additional_fields', $config['additional_fields']);        

        $container->setParameter('ggggino_skuskucart.stepform', $config['stepform']);

        $container->setParameter('ggggino_skuskucart.stepform_class', $config['stepform_class']);

        $container->setParameter('ggggino_skuskucart.cart_mode', $config['cart_mode']);        

        foreach ($config['templates'] as $key => $template) {
            $container->setParameter('ggggino_skuskucart.templates.' . $key, $template);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        /*$config = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');*/

        /** @var Definition $def */
        /*$def = $container->get('doctrine.orm.listeners.resolve_target_entity');
        die(get_class($def));
        $entities = $def->addMethodCall('addResolveTargetEntity', [
            $name,
            $implementation,
            [],
        ]);
        foreach ($config['resolve_target_entities'] as $name => $implementation) {
            $def->addMethodCall('addResolveTargetEntity', [
                $name,
                $implementation,
                [],
            ]);
        }
        $doctrineConfig = $container->getParameter('doctrine');
        var_dump($doctrineConfig);exit;*/
    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $this->prependDoctrineTargetEntities($container);

        $this->prependPayumGateway($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function prependDoctrineTargetEntities(ContainerBuilder $container)
    {
        $doctrineConfig = $container->getExtensionConfig('doctrine') ?: array(
            array(
                'orm' => array(
                    'resolve_target_entities' => array()
                )
            )
        );

        $arrayEntities = array_merge(...$doctrineConfig);
        $arrayEntities = $arrayEntities['orm']['resolve_target_entities'];

        $container->setParameter('skusku_abstract_entities', $arrayEntities);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function prependPayumGateway(ContainerBuilder $container)
    {
        if (!$container->hasExtension('payum')) {
            die('non ce payum');
        }

        $configs = $container->getExtensionConfig('payum') ?: array(
            array(
                'gateways' => array(
                )
            )
        );

        $arrayEntities = array_merge(...$configs);
        $arrayEntities = $arrayEntities['gateways'];
        $finalEntities = array();

        foreach ($arrayEntities as $key => $value) {
            $labelName = isset($value['name']) ? $value['name'] : $key;
            $finalEntities[$labelName] = $key;
        }

        $container->setParameter('skusku_gateways', $finalEntities);
    }

    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return 'ggggino_skuskucart';
    }
}
