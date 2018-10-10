<?php

namespace GGGGino\SkuskuCartBundle\Tests\Service;

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

        //$client->getContainer()->get(LangManager::class);

        $this->assertEquals(200, 200);
    }
}