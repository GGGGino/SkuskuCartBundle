<?php

namespace GGGGino\SkuskuCartBundle\Command;

use Allyou\ManagementBundle\Manipulator\AllyouServicesManipulator;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Table;
use GGGGino\SkuskuCartBundle\Service\CartManager;
use GGGGino\SkuskuCartBundle\Service\SkuskuHelper;
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
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class CurrencyCreateCommand
 * @package GGGGino\SkuskuCartBundle\Command
 */
class DoctorDbCommand extends ContainerAwareCommand
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
            ->setName('ggggino_skusku:doctor:db')
            ->setDescription('Check if this bundle is correctly installed on the db');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->skuskuHelper = $this->getContainer()->get(SkuskuHelper::class);

        $entityClass = $input->getArgument('entity');
        $classReflected = new \ReflectionClass($entityClass);
        $entityInstance = new $entityClass();

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $helper = $this->getHelper('question');

        $reader = new AnnotationReader();
        $classAnnotated = $reader->getClassAnnotation($classReflected, Table::class);

        $classReflectedProps = $classReflected->getProperties();

        foreach($classReflectedProps as $key => $value){
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