<?php

namespace GGGGino\SkuskuCartBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use GGGGino\SkuskuCartBundle\Entity\SkuskuLanguage;
use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;
use GGGGino\SkuskuCartBundle\Service\LangManager;
use GGGGino\SkuskuCartBundle\Tests\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartManagerTest extends WebTestCase
{
    private $client;

    protected static function createKernel(array $options = [])
    {
        return new TestKernel();
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->client = static::createClient();

        // Mock languages
        $repoLangs = $this->createMock(ObjectRepository::class);
        $repoLangs->expects($this->any())
            ->method('findAll')
            ->willReturn($this->fakeLanguages());

        // Last, mock the EntityManager to return the mock of the repository
        $objectManager = $this->createMock(EntityManager::class);
        // use getMock() on PHPUnit 5.3 or below
        // $objectManager = $this->getMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(SkuskuLangInterface::class))
            ->willReturn($repoLangs);

        static::$kernel->getContainer()->set('doctrine.orm.default_entity_manager', $objectManager);
    }

    private function fakeLanguages()
    {
        return array(
            (new SkuskuLanguage())->setName('Euro')->setIdentifier('EUR'),
            (new SkuskuLanguage())->setName('Lira')->setIdentifier('£')
        );
    }

    public function testFake()
    {
        //$this->client->request('GET', '/cart');

        /** @var LangManager $langManager */
        $langManager = $this->client->getContainer()->get(LangManager::class);
        //$langManager->setEm($objectManager);

        //var_dump($langManager->getCurrentLanguage());exit;

        $this->assertCount(2, $langManager->getActiveLanguages());
        //$this->assertEquals(1, $langManager->getCurrentLanguage());
    }
}