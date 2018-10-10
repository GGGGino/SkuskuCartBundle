<?php

namespace GGGGino\SkuskuCartBundle\Command;

use Allyou\ManagementBundle\Manipulator\AllyouServicesManipulator;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Sonata\AdminBundle\Command\Validators;
use Sonata\AdminBundle\Generator\AdminGenerator;
use Sonata\AdminBundle\Generator\ControllerGenerator;
use Sonata\AdminBundle\Manipulator\ServicesManipulator;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class CartCommand
 * @package GGGGino\SkuskuCartBundle\Command
 */
class CartCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName('ggggino_skusku:cart:clear')
            /*->setDescription('Generates an admin class based on the given model class')
            ->addArgument('model', InputArgument::REQUIRED, 'The fully qualified model class')
            ->addOption('bundle', 'b', InputOption::VALUE_OPTIONAL, 'The bundle name')
            ->addOption('admin', 'a', InputOption::VALUE_OPTIONAL, 'The admin class basename')
            ->addOption('controller', 'c', InputOption::VALUE_OPTIONAL, 'The controller class basename')
            ->addOption('manager', 'm', InputOption::VALUE_OPTIONAL, 'The model manager type')
            ->addOption('services', 'y', InputOption::VALUE_OPTIONAL, 'The services YAML file', 'services.yml')
            ->addOption('id', 'i', InputOption::VALUE_OPTIONAL, 'The admin service ID')*/
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CartManager $cartManager */
        $cartManager = $this->getContainer()->get(CartManager::class);
        $cartManager->clearCart();
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }
}