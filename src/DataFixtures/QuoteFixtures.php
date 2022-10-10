<?php

namespace App\DataFixtures;

use App\Factory\QuoteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuoteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        QuoteFactory::createOne([
            'content' => 'Qu\'est-ce que vous voulez-vous insinuyer Sire ?',
            'meta' => 'Roparzh, Kaamelott, Livre III, 74 : Saponides et detergents',
        ]);

        QuoteFactory::createOne([
            'content' => 'Sire, Sire ! On en a gros !',
            'meta' => 'Perceval, Kaamelott, Livre II, Les Exploités',
        ]);

        QuoteFactory::createOne([
            'content' => 'Mais évidemment c\'est sans alcool !',
            'meta' => 'Merlin, Kaamelott, Livre II, 4 : Le rassemblement du corbeau',
        ]);

        QuoteFactory::createOne([
            'content' => 'Quand on veut être sûr de son coup, Seigneur Dagonet… on plante des navets. On ne pratique pas le putsch.',
            'meta' => 'Loth, Kaamelott, Livre V, Les Repentants',
        ]);

        QuoteFactory::createOne([
            'content' => 'Vous savez c\'que c\'est, mon problème ? Trop gentil.',
            'meta' => 'Léodagan, Kaamelott, Livre II, Le complot',
        ]);

        QuoteFactory::createMany(5);
    }
}
