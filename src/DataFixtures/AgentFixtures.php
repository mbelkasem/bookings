<?php

namespace App\DataFixtures;

use App\Entity\Agent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AgentFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        $names = [
            "Emily Davis",
            "Michael Johnson",
            "David Wilson",
            "Jane Smith",
            "John Doe"
        ];

        foreach ($names as $name) {
            $agent = new Agent(); 
            $agent->setName($name);

            $manager->persist($agent);
            $this->addReference($name, $agent);
        }


        $manager->flush();
    }
}
