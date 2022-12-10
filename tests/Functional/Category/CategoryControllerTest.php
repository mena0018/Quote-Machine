<?php

namespace App\Tests\Functional\Category;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testCategoryIndexPage(): void
    {
        $client = static::createClient();
        $user = UserFactory::createOne()->object();
        $client->loginUser($user);

        $client->request('GET', '/category');

        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des catégories');
    }
}
