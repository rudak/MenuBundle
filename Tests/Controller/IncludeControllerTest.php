<?php

namespace Rudak\MenuBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IncludeControllerTest extends WebTestCase
{
    public function testGethtmlmenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getHtmlMenu');
    }

}
