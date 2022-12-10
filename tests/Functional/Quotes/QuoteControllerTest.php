<?php

namespace App\Tests\Functional\Quotes;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;

class QuoteControllerTest extends WebTestCase
{
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

    public function testEditionQuote(): void
    {
        /* Creation + authentification de l'utilisateur */
        $client = static::createClient();
        $user = UserFactory::createOne()->object();
        $client->loginUser($user);

        /* Creation de la citation */
        $client->request('POST', '/quote/new');
        $client->submitForm('Sauvegarder', [
            'quote[content]' => $this->content,
            'quote[meta]' => $this->meta,
        ]);

        /* Modification de cette citation */
        $client->request('POST', '/quote/1/edit');
        $client->submitForm('Sauvegarder', [
            'quote[content]' => $this->content.' modifiée',
            'quote[meta]' => $this->meta,
        ]);

        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('blockquote', $this->content.' modifiée');
        $this->assertSelectorTextContains('cite', $this->meta);
    }

    public function testDeletionQuote(): void
    {
        /* Creation + authentification de l'utilisateur */
        $client = static::createClient();
        $user = UserFactory::createOne()->object();
        $client->loginUser($user);

        /* Creation de la citation */
        $client->request('POST', '/quote/new');
        $client->submitForm('Sauvegarder', [
            'quote[content]' => $this->content,
            'quote[meta]' => $this->meta,
        ]);

        /* Suppression de cette citation */
        $client->request('DELETE', '/quote/1/delete');

        $client->followRedirect();

        $this->assertSelectorNotExists('blockquote');
        $this->assertSelectorNotExists('cite');
    }
}
