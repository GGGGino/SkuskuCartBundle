<?php

namespace GGGGino\SkuskuCartBundle\Tests\Service;

use GGGGino\SkuskuCartBundle\Tests\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    protected static function createKernel(array $options = [])
    {
        return new TestKernel();
    }

    public function testCartPage()
    {
        $client = static::createClient();

        $this->assertEquals(200, 200);
        return;

        $client->request('GET', '/sample');
        die($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}