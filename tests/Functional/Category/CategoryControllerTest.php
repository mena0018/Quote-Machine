<?php

namespace App\Tests\Functional\Category;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;

class CategoryControllerTest extends WebTestCase
{
    use Factories;

    private const NAME = 'Kaamelott-Test';

    public function testCategoryIndexPage(): void
    {
        $client = static::createClient();
        $user = UserFactory::createOne()->object();
        $client->loginUser($user);

        $client->request('GET', '/category/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des catégories');
    }

    public function testCreationCategory(): void
    {
        $client = static::createClient();
        $user = UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
        ])->object();
        $client->loginUser($user);

        $client->request('GET', '/category/new');
        $client->submitForm('Sauvegarder', [
            'category[name]' => self::NAME,
        ]);

        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->assertRouteSame('app_category_index');
        $this->assertSelectorTextContains('body', self::NAME);
    }
}
