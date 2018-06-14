<?php

namespace GGGGino\SkuskuCartBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClearCartsCommand
 * @package GGGGino\SkuskuCartBundle\Command
 */
class ClearCartsCommand extends Command
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('ggggino:skusku:clear')
            ->setDescription('Clear expired carts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Purging expired carts...');

        $cartsPurger = $this->get('sylius.cart.purger');
        $cartsPurger->purge();

        $output->writeln('Expired carts purged.');
    }
}