<?php

namespace GGGGino\SkuskuCartBundle\Command;

use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Model\SkuskuCurrencyInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use GGGGino\SkuskuCartBundle\Service\SkuskuHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DoctorDbCommand
 * @package GGGGino\SkuskuCartBundle\Command
 */
class DoctorDbCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName('ggggino_skusku:doctor:db')
            ->setDescription('Check if this bundle is correctly installed on the db');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencyText = $this->checkCurrencyOnDb();
        $output->writeln($currencyText);
    }

    /**
     * Check if exists at least one currency
     * Tip: ggggino_skusku:currency:create
     *
     * @return string
     */
    private function checkCurrencyOnDb()
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        /** @var SkuskuCurrencyInterface[] $Currencies */
        $currencies = $em->getRepository(SkuskuCurrencyInterface::class)->findAll();

        if ( count($currencies) > 0 ) {
            return 'Currency: <info> correct</info>';
        } else {
            return 'Currency: <error>not correct</error>';
        }
    }
}