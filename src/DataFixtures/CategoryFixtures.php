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
            'name' => 'Kaameloott'
        ]);

        CategoryFactory::createOne([
            'name' => 'Peaky Blinders'
        ]);

        CategoryFactory::createMany(5);

        $manager->flush();
    }
}
