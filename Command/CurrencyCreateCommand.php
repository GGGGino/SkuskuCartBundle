<?php

namespace GGGGino\SkuskuCartBundle\Command;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Table;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use GGGGino\SkuskuCartBundle\Service\SkuskuHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class CurrencyCreateCommand
 * @package GGGGino\SkuskuCartBundle\Command
 */
class CurrencyCreateCommand extends ContainerAwareCommand
{
    /**
     * @var SkuskuHelper
     */
    private $skuskuHelper;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName('ggggino_skusku:currency:create')
            ->setDescription('Create a Currency')
            ->addArgument('entity', InputArgument::OPTIONAL, 'The fully qualified model class');
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->skuskuHelper = $this->getContainer()->get(SkuskuHelper::class);

        /** @var array $abstractEntities */
        $abstractEntities = $this->skuskuHelper->getAbstractEntities();
        $abstractEntitiesInverted = array_flip($abstractEntities);

        $helper = $this->getHelper('question');

        // If i make a mistake writing the class this enforce you to chose
        // @todo now i'm forced to write thee entity namespace wth 2 backslash otherwise it will be removed
        if ( !in_array($input->getArgument('entity'), $abstractEntities) ) {
            $output->writeln('<error>Entity: ' . $input->getArgument('entity') . ' Not found</error>');
            $question = new ChoiceQuestion(
                'Please select the entity',
                array_keys($abstractEntitiesInverted)
            );
            $question->setErrorMessage('Entity %s is invalid.');

            $concreteClass = $helper->ask($input, $output, $question);

            $input->setArgument('entity', $concreteClass);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityClass = $input->getArgument('entity');
        $classReflected = new \ReflectionClass($entityClass);
        $entityInstance = new $entityClass();

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $helper = $this->getHelper('question');

        $reader = new AnnotationReader();
        $classAnnotated = $reader->getClassAnnotation($classReflected, Table::class);

        $classReflectedProps = $classReflected->getProperties();

        foreach($classReflectedProps as $key => $value) {
            $question = new Question('Set value for (' . $value->name . '): ', false);

            $response = $helper->ask($input, $output, $question);
            if( !$response ){
                continue;
            }
            $propertyAccessor->setValue($entityInstance, $value->name, $response);
        }

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($entityInstance);
        $em->flush();

        $output->writeln('Entity created');
    }
}