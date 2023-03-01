<?php

namespace App\Tests\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    private const EMAIL = 'test@example.com';
    private const NAME = 'David';
    private const PASSWORD = 'Test1234';

    public function testRegistration(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertResponseIsSuccessful();

        $client->submitForm('Valider', [
          'registration_form[email]' => self::EMAIL,
          'registration_form[name]' => self::NAME,
          'registration_form[plainPassword]' => self::PASSWORD,
        ]);

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('quote_index');
    }
}
