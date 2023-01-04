<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\QuoteFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuoteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $kaamelottCategory = CategoryFactory::find(['name' => 'Kaamelott']);
        $user = UserFactory::find(['email' => 'admin@admin.fr']);

        QuoteFactory::createOne([
            'content' => 'Qu\'est-ce que vous voulez-vous insinuer Sire ?',
            'meta' => 'Roparzh, Kaamelott, Livre III, 74 : Saponides et detergents',
            'category' => $kaamelottCategory,
            'author' => $user,
        ]);

        QuoteFactory::createOne([
            'content' => 'Sire, Sire ! On en a gros !',
            'meta' => 'Perceval, Kaamelott, Livre II, Les Exploités',
            'category' => $kaamelottCategory,
            'author' => $user,
        ]);

        QuoteFactory::createOne([
            'content' => 'Mais évidemment c\'est sans alcool !',
            'meta' => 'Merlin, Kaamelott, Livre II, 4 : Le rassemblement du corbeau',
            'category' => $kaamelottCategory,
            'author' => $user,
        ]);

        QuoteFactory::createOne([
            'content' => 'Quand on veut être sûr de son coup, Seigneur Dagonet… on plante des navets. On ne pratique pas le putsch.',
            'meta' => 'Loth, Kaamelott, Livre V, Les Repentants',
            'category' => $kaamelottCategory,
            'author' => $user,
        ]);

        QuoteFactory::createOne([
            'content' => 'Vous savez c\'que c\'est, mon problème ? Trop gentil.',
            'meta' => 'Léodagan, Kaamelott, Livre II, Le complot',
            'category' => $kaamelottCategory,
            'author' => $user,
        ]);

        QuoteFactory::createMany(5, function () {
            return ['category' => CategoryFactory::random(), 'author' => UserFactory::random()];
        });
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
