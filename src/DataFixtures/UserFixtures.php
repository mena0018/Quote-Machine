<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'admin@admin.fr',
            'password' => '12341234',
            'roles' => ['ROLE_ADMIN'],
            'name' => 'Admin',
        ]);

        UserFactory::createOne([
            'email' => 'user@user.fr',
            'password' => '1234',
            'name' => 'User',
        ]);
    }
}
