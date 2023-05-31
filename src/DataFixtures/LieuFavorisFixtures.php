<?php

namespace App\DataFixtures;

use App\Entity\Lieufavoris;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LieuFavorisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = [
            'bob',
            'fred',
            'alice',
            'john',
            'emma',
        ];

        $lieux = [
            [
                'designation' => 'Espace Delvaux / La Vénerie',
            ],
            [
                'designation' => 'Dexia Art Center',
            ],
            [
                'designation' => 'La Samaritaine',
            ],
            [
                'designation' => 'Espace Magh',
            ],
        ];

        foreach ($users as $userLogin) {
            $user = $this->getReference($userLogin);

            foreach ($lieux as $record) {
                $lieuFavoris = new Lieufavoris();
                $slugify = new Slugify();
                $locationSlug = $slugify->slugify($record['designation']);
                $lieuFavoris->setLocation($this->getReference($locationSlug));
                $lieuFavoris->setUser($user);
                $lieuFavoris->setNote(mt_rand(1, 5));

                $manager->persist($lieuFavoris);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            LocationFixtures::class,
        ];
    }
}
