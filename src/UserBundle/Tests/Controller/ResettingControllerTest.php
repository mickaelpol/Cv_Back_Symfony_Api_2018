<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResettingControllerTest extends WebTestCase
{
    public function testReset()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reset');
    }

}
