<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteControllerTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quote/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des citations');
    }
}
