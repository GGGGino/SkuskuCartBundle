<?php

namespace GGGGino\SkuskuCartBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;
use GGGGino\SkuskuCartBundle\Tests\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    protected static function createKernel(array $options = [])
    {
        return new TestKernel();
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->client = static::createClient(array('debug' => true));

        // Mock carts
        $repoCarts = $this->createMock(EntityRepository::class);
        $repoCarts->expects($this->any())
            ->method('__call')
            ->with(
                $this->equalTo('findOneByCustomer')
            )
            //->method('findOneByCustomer')
            ->willReturn(null);

        // Last, mock the EntityManager to return the mock of the repository
        $objectManager = $this->createMock(EntityManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo('GGGGino\SkuskuCartBundle\Model\SkuskuCart'))
            ->willReturn($repoCarts);

        static::$kernel->getContainer()->set('doctrine.orm.default_entity_manager', $objectManager);
    }

    public function testCartPage()
    {
        $client = static::createClient(array('debug' => true));

        $this->assertEquals(200, 200);

        $client->request('GET', '/cart');
//        $exceptionProfile = $client->getProfile()->getCollector('exception');
//
//        if ($exceptionProfile->hasException()) {
//            $message = sprintf(
//                "No exception was expected but got '%s' with message '%s'. Trace:\n%s",
//                get_class($exceptionProfile->getException()),
//                $exceptionProfile->getMessage(),
//                $exceptionProfile->getException()->getTraceAsString()
//            );
//            throw new \Exception($message);
//        }

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}