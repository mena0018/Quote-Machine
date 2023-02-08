<?php

namespace App\Tests\Functional\Quotes;

use App\Factory\QuoteFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;

class QuoteControllerTest extends WebTestCase
{
    use Factories;

    private const CONTENT = 'Ceci est une citation de test';
    private const META = 'PhpUnit';

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
            'quote[content]' => self::CONTENT,
            'quote[meta]' => self::META,
        ]);

        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('quote_index');

        $this->assertSelectorTextContains('blockquote', self::CONTENT);
        $this->assertSelectorTextContains('cite', self::META);
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
            'quote[content]' => self::CONTENT,
            'quote[meta]' => self::META,
        ]);

        /* Modification de cette citation */
        $client->request('POST', '/quote/1/edit');
        $client->submitForm('Sauvegarder', [
            'quote[content]' => self::CONTENT.' modifiée',
            'quote[meta]' => self::META,
        ]);

        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('blockquote', self::CONTENT.' modifiée');
        $this->assertSelectorTextContains('cite', self::META);
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
            'quote[content]' => self::CONTENT,
            'quote[meta]' => self::META,
        ]);

        /* Suppression de cette citation */
        $client->request('DELETE', '/quote/1/delete');

        $client->followRedirect();

        $this->assertSelectorNotExists('blockquote');
        $this->assertSelectorNotExists('cite');
    }

    public function assertResponseIsAttachment(string $filename, string $message = ''): void
    {
        $headerValue = sprintf(
            'attachment; filename=%s',
            $filename,
        );

        self::assertResponseHeaderSame('content-disposition', $headerValue, $message);
    }

    public function testExportCsv(): void
    {
        $client = static::createClient();
        QuoteFactory::createMany(10);

        $client->request('GET', '/quote');
        $client->followRedirect();
        $client->clickLink('Exporter en CSV');

        $this->assertResponseIsAttachment('quote.csv');
        $csv = array_map('str_getcsv', array_filter(explode("\n", $client->getResponse()->getContent())));
        $this->assertCount(11, $csv);
    }
}
