<?php

namespace App\Tests\Controller;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;

class QuoteControllerTest extends WebTestCase
{
    // Permet à foundry de fonctionner dans les tests
    use Factories;

    private string $content = 'Ceci est une citation de test';
    private string $meta = 'PhpUnit';

    public function testHomePage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quote/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des citations');
    }

    public function testCreationQuote(): void
    {
        $client = static::createClient();
        $user = UserFactory::createOne()->object();

        // simule que $user est authentifié
        $client->loginUser($user);

        $client->request('POST', '/quote/new');
        $client->submitForm('Sauvegarder', [
            'quote[content]' => $this->content,
            'quote[meta]' => $this->meta,
        ]);

        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->assertRouteSame('quote_index');
        $this->assertSelectorTextContains('blockquote', $this->content);
        $this->assertSelectorTextContains('cite', $this->meta);
    }
}
