<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artist;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $artists = [
            ['firstname' => 'Daniel', 'lastname' => 'Marcelin', 'agent' => 'John Doe'],
            ['firstname' => 'Philippe', 'lastname' => 'Laurent', 'agent' => 'Michael Johnson'],
            ['firstname' => 'Marius', 'lastname' => 'Von Mayenburg', 'agent' => 'Emily Davis'],
            ['firstname' => 'Olivier', 'lastname' => 'Boudon', 'agent' => 'David Wilson'],
            ['firstname' => 'Anne Marie', 'lastname' => 'Loop', 'agent' => 'Jane Smith'],
            ['firstname' => 'Pietro', 'lastname' => 'Varasso', 'agent' => 'David Wilson'],
            ['firstname' => 'Laurent', 'lastname' => 'Caron', 'agent' => 'John Doe'],
            ['firstname' => 'Élena', 'lastname' => 'Perez', 'agent' => 'Michael Johnson'],
            ['firstname' => 'Guillaume', 'lastname' => 'Alexandre', 'agent' => 'John Doe'],
            ['firstname' => 'Claude', 'lastname' => 'Semal', 'agent' => 'John Doe'],
            ['firstname' => 'Laurence', 'lastname' => 'Warin', 'agent' => 'Emily Davis'],
            ['firstname' => 'Pierre', 'lastname' => 'Wayburn', 'agent' => 'Jane Smith'],
            ['firstname' => 'Gwendoline', 'lastname' => 'Gauthier', 'agent' => 'John Doe'],
        ];

        foreach ($artists as $record) {
            $agentName = $record['agent'];
            $agent = $this->getReference($agentName);

            $artist = new Artist();
            $artist->setFirstname($record['firstname']);
            $artist->setLastname($record['lastname']);
            $artist->setAgent($agent);

            $manager->persist($artist);
            $this->addReference($record['firstname'] . '-' . $record['lastname'], $artist);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [AgentFixtures::class];
    }
}
