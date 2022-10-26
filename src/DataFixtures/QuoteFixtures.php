<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\QuoteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuoteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $kaamelottCategory = CategoryFactory::find(['name' => 'Kaamelott']);

        QuoteFactory::createOne([
            'content' => 'Qu\'est-ce que vous voulez-vous insinuyer Sire ?',
            'meta' => 'Roparzh, Kaamelott, Livre III, 74 : Saponides et detergents',
            'category' => $kaamelottCategory
        ]);

        QuoteFactory::createOne([
            'content' => 'Sire, Sire ! On en a gros !',
            'meta' => 'Perceval, Kaamelott, Livre II, Les Exploités',
            'category' => $kaamelottCategory
        ]);

        QuoteFactory::createOne([
            'content' => 'Mais évidemment c\'est sans alcool !',
            'meta' => 'Merlin, Kaamelott, Livre II, 4 : Le rassemblement du corbeau',
            'category' => $kaamelottCategory
        ]);

        QuoteFactory::createOne([
            'content' => 'Quand on veut être sûr de son coup, Seigneur Dagonet… on plante des navets. On ne pratique pas le putsch.',
            'meta' => 'Loth, Kaamelott, Livre V, Les Repentants',
            'category' => $kaamelottCategory
        ]);

        QuoteFactory::createOne([
            'content' => 'Vous savez c\'que c\'est, mon problème ? Trop gentil.',
            'meta' => 'Léodagan, Kaamelott, Livre II, Le complot',
            'category' => $kaamelottCategory
        ]);

        QuoteFactory::createMany(5, function() {
            return ['category' => CategoryFactory::random()];
        });
    }
}
