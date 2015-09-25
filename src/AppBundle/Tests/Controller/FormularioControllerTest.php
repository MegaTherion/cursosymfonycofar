<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormularioControllerTest extends WebTestCase
{
    public function testSimpleform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/simpleform');
    }

}
