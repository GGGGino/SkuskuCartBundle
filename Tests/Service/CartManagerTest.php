<?php

namespace GGGGino\SkuskuCartBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use GGGGino\SkuskuCartBundle\Model\SkuskuCart;
use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;
use GGGGino\SkuskuCartBundle\Service\CartManager;
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
    }

    private function fakeCartTemp()
    {
        return new SkuskuCart();
    }

    private function fakeCartPermanent()
    {
        $cart = new SkuskuCart();
        $reflectionClass = new \ReflectionClass(SkuskuCart::class);

        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($cart, 6);

        return $cart;
    }

    private function fakeCartFull()
    {
        $cart = $this->fakeCartPermanent();
        return $cart;
    }

    public function testCartTemp()
    {
        /** @var CartManager $cartManager */
        $cartManager = $this->createPartialMock(CartManager::class, array('getCartFromCustomer'));
        $cartManager->expects($this->any())
            ->method('getCartFromCustomer')
            ->willReturn($this->fakeCartTemp());

        $cart = $cartManager->getCartFromCustomer();

        $this->assertEquals(SkuskuCart::class, get_class($cart));
        $this->assertTrue($cartManager->isCartTemp($cart));
    }

    public function testCartPermanent()
    {
        /** @var CartManager $cartManager */
        $cartManager = $this->createPartialMock(CartManager::class, array('getCartFromCustomer'));
        $cartManager->expects($this->any())
            ->method('getCartFromCustomer')
            ->willReturn($this->fakeCartPermanent());

        $cart = $cartManager->getCartFromCustomer();

        $this->assertEquals(SkuskuCart::class, get_class($cart));
        $this->assertFalse($cartManager->isCartTemp($cart));
    }

    public function testCartFull()
    {
        /** @var CartManager $cartManager */
        $cartManager = $this->createPartialMock(CartManager::class, array('getCartFromCustomer'));
        $cartManager->expects($this->any())
            ->method('getCartFromCustomer')
            ->willReturn($this->fakeCartPermanent());

        $cart = $cartManager->getCartFromCustomer();

        $this->assertEquals(SkuskuCart::class, get_class($cart));
        $this->assertFalse($cartManager->isCartTemp($cart));
    }
}