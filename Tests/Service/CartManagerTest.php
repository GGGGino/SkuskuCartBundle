<?php

namespace GGGGino\SkuskuCartBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use GGGGino\SkuskuCartBundle\Entity\SkuskuLanguage;
use GGGGino\SkuskuCartBundle\Service\LangManager;
use GGGGino\SkuskuCartBundle\Tests\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartManagerTest extends WebTestCase
{
    protected static function createKernel(array $options = [])
    {
        return new TestKernel();
    }

    public function testFake()
    {
        $client = static::createClient();

        $lang = new SkuskuLanguage();
        $lang->setName('EURO');
        $lang->setIdentifier('EUR');

        // Now, mock the repository so it returns the mock of the employee
        $employeeRepository = $this->createMock(ObjectRepository::class);
        $employeeRepository->expects($this->any())
            ->method('findAll')
            ->willReturn([$lang]);

        // Last, mock the EntityManager to return the mock of the repository
        $objectManager = $this->createMock(EntityManager::class);
        // use getMock() on PHPUnit 5.3 or below
        // $objectManager = $this->getMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($employeeRepository);

        /** @var LangManager $langManager */
        $langManager = $client->getContainer()->get(LangManager::class);
        $langManager->setEm($objectManager);

        $this->assertCount(1, $langManager->getActiveLanguages());
    }
}