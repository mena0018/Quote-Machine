<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createOne([
            'name' => 'Kaamelott',
            'image_name' => 'kameloot.jpeg',
        ]);

        CategoryFactory::createOne([
            'name' => 'Peaky Blinders',
            'image_name' => 'peaky.jpeg',
        ]);

        CategoryFactory::createMany(5);

        $manager->flush();
    }
}
